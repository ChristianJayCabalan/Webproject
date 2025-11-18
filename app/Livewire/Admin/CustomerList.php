<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Carbon\Carbon;

class CustomerList extends Component
{
    public $users;

    public function mount()
    {
        // Fetch all non-admin users
        $this->users = User::where('role', '!=', 0)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($user) {
                // Determine status based on last_login_at (or updated_at if last_login_at not available)
                $lastActivity = $user->last_login_at ?? $user->updated_at;
                $user->status = Carbon::parse($lastActivity)->diffInDays(now()) > 30 ? 'Inactive' : 'Active';
                return $user;
            });
    }

    public function render()
    {
        return view('livewire.admin.customer-list', [
            'users' => $this->users,
        ])->layout('components.layouts.admin');
    }
}
