<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserShowLive extends Component
{
    public User $user;

    public function render()
    {
        return view('livewire.user-show-live');
    }
}
