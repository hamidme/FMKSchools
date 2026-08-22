<?php

namespace App\Http\Controllers;

use App\Mail\ContactEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'in:admissions,fees,academics,general'],
            'message' => ['required', 'string'],
        ]);

        Mail::to('info@fmkschools.edu.ng')->send(new ContactEnquiry(
            name: $validated['name'],
            email: $validated['email'],
            phone: $validated['phone'] ?? null,
            enquirySubject: $validated['subject'],
            enquiryMessage: $validated['message'],
        ));

        return redirect()->route('contact')->with('success', true);
    }
}
