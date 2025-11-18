<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class AdminCustomerMessages extends Component
{
    public $messages;
    public $messageText = '';
    public $user_id;

    public function mount()
{
    $firstUser = User::first();
    $this->user_id = $firstUser ? $firstUser->id : null;
    $this->loadMessages();
}


public function updatedUserId()
{
    $this->loadMessages();
}

public function loadMessages()
{
    if ($this->user_id) {
        $this->messages = Message::where('user_id', $this->user_id)
            ->orderBy('created_at', 'asc')
            ->get();
    } else {
        $this->messages = collect(); // empty collection if no user selected
    }
}



    public function sendMessage()
{
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Unauthorized action.');
    }

    $this->validate([
        'user_id' => 'required|exists:users,id',
        'messageText' => 'required|string|max:1000',
    ]);

    Message::create([
        'user_id' => $this->user_id,
        'message' => $this->messageText,
        'is_admin' => true,
    ]);

    $this->messageText = '';
    $this->loadMessages();
}


    public function render()
    {
        return view('livewire.admin-customer-messages', [
            'users' => User::all(),
        ])->layout('components.layouts.admin');
    }
}
