<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileComponent extends Component
{
    use WithFileUploads;

    public $name, $email, $profile_image, $new_profile_image;

    public function mount()
    {
        $this->loadProfile();
    }

    public function index()
    {
        $this->loadProfile();
    }

    protected function loadProfile()
    {
        $admin = Auth::user();
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->profile_image = $admin->profile_image;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'new_profile_image' => 'nullable|image|max:1024', // 1MB max
        ]);

        $admin = Auth::user();
        $admin->name = $this->name;
        $admin->email = $this->email;

        if ($this->new_profile_image) {
            if ($admin->profile_image && Storage::disk('public')->exists('profiles/' . $admin->profile_image)) {
                Storage::disk('public')->delete('profiles/' . $admin->profile_image);
            }

            $filename = uniqid() . '.' . $this->new_profile_image->getClientOriginalExtension();
            $this->new_profile_image->storeAs('profiles', $filename, 'public');
            $admin->profile_image = $filename;
        }

        $admin->save();

        session()->flash('success', 'Profile updated successfully.');
        $this->profile_image = $admin->profile_image;
    }

    public function render()
    {
        return view('livewire.admin-profile-component')->layout('components.layouts.admin');
    }
}
