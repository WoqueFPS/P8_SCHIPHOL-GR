<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Flight;
use App\Models\DirectorSetting;
use App\Models\DirectorBroadcast;
use App\Models\TeamAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function checkDirecteur()
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff || $staff->role !== 'directeur') {
            abort(403, 'Alleen toegankelijk voor de directie.');
        }
        return $staff;
    }

    public function index()
    {   
        $staff = $this->checkDirecteur();
        $coordinatoren = Staff::where('role', 'coordinator')->get();
        $totaalCoordinatoren = $coordinatoren->count();
        $actieveVluchten = Flight::count(); 
        $openMeldingen = 3;
        
        // Director settings from database
        $noodmodus = DirectorSetting::getValue('noodmodus', 'false') === 'true';
        $prioriteit = DirectorSetting::getValue('vluchtprioriteit', 'intercontinentaal');
        
        // Team allocations
        $teamAllocations = [
            'oost' => TeamAllocation::getTeamCount('oost') ?? 4,
            'west' => TeamAllocation::getTeamCount('west') ?? 3,
            'cargo' => TeamAllocation::getTeamCount('cargo') ?? 2,
        ];
        
        // Active broadcast
        $activeBroadcast = DirectorBroadcast::getActiveBroadcast();
        
        return view('staff.reports.index', compact(
            'staff',
            'coordinatoren', 
            'totaalCoordinatoren', 
            'actieveVluchten', 
            'openMeldingen',
            'noodmodus',
            'prioriteit',
            'teamAllocations',
            'activeBroadcast'
        ));
    }

    // Director action: toggle noodmodus
    public function toggleNoodmodus()
    {
        $this->checkDirecteur();
        $current = DirectorSetting::getValue('noodmodus', 'false');
        $newValue = $current === 'true' ? 'false' : 'true';
        DirectorSetting::setValue('noodmodus', $newValue);
        
        return response()->json([
            'success' => true,
            'noodmodus' => $newValue === 'true',
            'message' => $newValue === 'true' ? 'Noodmodus geactiveerd' : 'Noodmodus gedeactiveerd'
        ]);
    }
    
    // Director action: set priority
    public function setPriority(Request $request)
    {
        $this->checkDirecteur();
        $request->validate(['priority' => 'required|in:intercontinentaal,europees,cargo']);
        
        DirectorSetting::setValue('vluchtprioriteit', $request->priority);
        
        return response()->json([
            'success' => true,
            'priority' => $request->priority,
            'message' => 'Prioriteit bijgewerkt naar ' . $request->priority
        ]);
    }
    
    // Director action: broadcast message
    public function broadcastMessage(Request $request)
    {
        $this->checkDirecteur();
        $request->validate(['message' => 'required|string|max:1000']);
        
        // Deactivate old broadcasts
        DirectorBroadcast::where('is_active', true)->update(['is_active' => false]);
        
        // Create new broadcast
        $broadcast = DirectorBroadcast::create([
            'message' => $request->message,
            'sent_by' => Auth::guard('staff')->id(),
            'is_active' => true,
            'expires_at' => now()->addDays(7), // Expires after 7 days
        ]);
        
        return response()->json([
            'success' => true,
            'broadcast' => $broadcast,
            'message' => 'Bericht verzonden naar alle coördinatoren'
        ]);
    }
    
    // Director action: update team allocation
    public function updateTeam(Request $request)
    {
        $this->checkDirecteur();
        $request->validate([
            'team' => 'required|in:oost,west,cargo',
            'action' => 'required|in:increase,decrease,set'
        ]);
        
        $team = TeamAllocation::firstOrNew(['team_name' => $request->team]);
        $currentCount = $team->coordinator_count ?? ($request->team === 'oost' ? 4 : ($request->team === 'west' ? 3 : 2));
        
        if ($request->action === 'increase') {
            $newCount = $currentCount + 1;
        } elseif ($request->action === 'decrease') {
            $newCount = max(0, $currentCount - 1);
        } else {
            $newCount = $request->input('count', $currentCount);
        }
        
        $team->coordinator_count = $newCount;
        $team->save();
        
        return response()->json([
            'success' => true,
            'team' => $request->team,
            'count' => $newCount,
            'message' => "Team {$request->team} bijgewerkt naar {$newCount} coördinatoren"
        ]);
    }
    
    // Reset all teams to default
    public function resetTeams()
    {
        $this->checkDirecteur();
        $defaults = ['oost' => 4, 'west' => 3, 'cargo' => 2];
        
        foreach ($defaults as $team => $count) {
            TeamAllocation::updateOrCreate(
                ['team_name' => $team],
                ['coordinator_count' => $count]
            );
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Teams gereset naar standaard configuratie'
        ]);
    }
    
    // Get current director settings (for API)
    public function getSettings()
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return response()->json([
            'noodmodus' => DirectorSetting::getValue('noodmodus', 'false') === 'true',
            'prioriteit' => DirectorSetting::getValue('vluchtprioriteit', 'intercontinentaal'),
            'activeBroadcast' => DirectorBroadcast::getActiveBroadcast(),
            'teamAllocations' => [
                'oost' => TeamAllocation::getTeamCount('oost') ?? 4,
                'west' => TeamAllocation::getTeamCount('west') ?? 3,
                'cargo' => TeamAllocation::getTeamCount('cargo') ?? 2,
            ]
        ]);
    }
    
    // Existing methods remain the same
    public function create()
    {
        $this->checkDirecteur();
        return view('staff.reports.create');
    }

    public function show($id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);
        return view('staff.reports.show', compact('coordinator'));
    }

    public function store(Request $request)
    {
        $this->checkDirecteur();
        $request->validate([
            'naam' => 'required|string|max:255',
            'afdeling' => 'required|string|max:255',
        ]);

        $cleanName = strtolower(str_replace(' ', '', $request->naam));
        $generatedEmail = $cleanName . '.' . rand(10, 99) . '@schiphol.nl';

        Staff::create([
            'name' => $request->naam,
            'department' => $request->afdeling, 
            'email' => $generatedEmail,         
            'password' => bcrypt('Welkom01!'),   
            'role' => 'coordinator',
        ]);

        return redirect()->route('staff.reports.index');
    }

    public function edit($id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);
        return view('staff.reports.edit', compact('coordinator'));
    }

    public function update(Request $request, $id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);

        $request->validate([
            'naam' => 'required|string|max:255',
            'afdeling' => 'required|string|max:255',
        ]);

        $coordinator->update([
            'name' => $request->naam,
            'department' => $request->afdeling,
        ]);

        return redirect()->route('staff.reports.index');
    }

    public function destroy($id)
    {
        $this->checkDirecteur();
        $coordinator = Staff::where('role', 'coordinator')->findOrFail($id);
        $coordinator->delete();

        return redirect()->route('staff.reports.index');
    }
}