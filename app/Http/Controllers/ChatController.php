<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    // User view
    public function userChat()
{
    $user = Auth::user();
    $admin = User::where('role', 0)->first();

    // Mark unread admin messages as read
    Message::where('receiver_id', $user->id)
        ->where('sender_id', $admin->id)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $messages = Message::where(function($q) use ($user, $admin){
        $q->where('sender_id', $user->id)
          ->where('receiver_id', $admin->id);
    })->orWhere(function($q) use ($user, $admin){
        $q->where('sender_id', $admin->id)
          ->where('receiver_id', $user->id);
    })->orderBy('created_at','asc')->get();

    return view('user-chat', compact('user', 'admin', 'messages'));
}


    // Admin view
    public function adminChat()
    {
        $admin = Auth::user();
        $users = User::where('role', 1)->get(); // lahat ng customers

        return view('admin-chat', compact('admin', 'users'));
    }

    // Send message (pareho sa user at admin)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back();
    }
    // Sa ChatController.php
public function getUserMessages(User $user)
{
    $admin = Auth::user();

    // Mark unread messages as read
    Message::where('sender_id', $user->id)
        ->where('receiver_id', $admin->id)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $messages = Message::with('sender')
        ->where(function($q) use ($user, $admin){
            $q->where('sender_id', $user->id)
              ->where('receiver_id', $admin->id);
        })->orWhere(function($q) use ($user, $admin){
            $q->where('sender_id', $admin->id)
              ->where('receiver_id', $user->id);
        })
        ->orderBy('created_at','asc')
        ->get();

    return response()->json($messages);
}



}
