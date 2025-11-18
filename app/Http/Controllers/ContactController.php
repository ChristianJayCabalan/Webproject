<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    // ✅ This method will display the contact page
    public function index()
    {
        return view('contact'); // Make sure you have a 'contact.blade.php' in views folder
    }

    // ✅ This method will handle form submission
    public function submit(Request $request)
    {
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store the message
        ContactMessage::create($request->all());

        // Redirect with success message
        return back()->with('success', 'Your message has been sent successfully!');
    }
}
