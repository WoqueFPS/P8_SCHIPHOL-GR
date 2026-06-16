<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255'],
            'department' => ['nullable', 'string', 'max:100'],
            'subject'    => ['required', 'string', 'max:255'],
            'message'    => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        Contact::create($validated);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Uw bericht is verzonden. We nemen zo snel mogelijk contact op.');
    }
}