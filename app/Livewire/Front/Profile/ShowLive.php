<?php

namespace App\Livewire\Front\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.front')]
class ShowLive extends Component
{
    public function render()
    {
        return view('livewire.front.profile.show-live');
    }
}
