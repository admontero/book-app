<?php

namespace App\Livewire\Author;

use App\Models\Author;
use Illuminate\View\View;
use Livewire\Component;

class ShowLive extends Component
{
    public Author $author;

    public function render(): View
    {
        return view('livewire.author.show-live');
    }
}
