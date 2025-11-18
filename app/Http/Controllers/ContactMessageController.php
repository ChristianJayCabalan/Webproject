<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    // Show chat view with messages
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('google.login')->with('error', 'Please log in with Google to chat.');
        }

        // Get all messages for logged-in user
        $messages = ContactMessage::where('user_id', Auth::id())
                    ->orderBy('created_at', 'asc')
                    ->get();

        return view('chat', compact('messages'));
    }

    // Handle sending message
    public function submit(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        ContactMessage::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false, // user sent
        ]);

        return redirect()->back()->with('success', 'Message sent!');
    }
}
