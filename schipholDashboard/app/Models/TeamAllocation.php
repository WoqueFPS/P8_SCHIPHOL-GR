<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamAllocation extends Model
{
    protected $fillable = ['team_name', 'coordinator_count'];
    
    public static function getTeamCount($teamName)
    {
        $team = self::where('team_name', $teamName)->first();
        return $team ? $team->coordinator_count : null;
    }
}