<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class UserNotifications extends Component
{
    public $unreadCount = 0;

    protected $listeners = ['refreshUserNotifications' => 'loadUnreadMessages'];

    public function mount()
    {
        $this->loadUnreadMessages();
    }

    public function loadUnreadMessages()
    {
        $this->unreadCount = Message::where('receiver_id', Auth::id())
            ->whereHas('sender', function($q) {
                $q->where('role', 0); // only admin messages
            })
            ->where('is_read', false)
            ->count();
    }

    public function render()
    {
        return view('livewire.user-notifications');
    }
}
