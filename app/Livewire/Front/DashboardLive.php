<?php

namespace App\Livewire\Front;

use Illuminate\View\View;
use Livewire\Component;

class DashboardLive extends Component
{
    public function render(): View
    {
        return view('livewire.front.dashboard-live')
            ->layout('layouts.front');
    }
}
