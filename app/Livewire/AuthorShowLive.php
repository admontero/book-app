<?php

namespace App\Livewire;

use App\Models\Author;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AuthorShowLive extends Component
{
    public Author $author;

    #[Computed]
    public function date_of_birth(): ?string
    {
        return $this->author->date_of_birth?->format('d/m/Y');
    }

    #[Computed]
    public function date_of_death(): ?string
    {
        return $this->author->date_of_death?->format('d/m/Y');
    }

    public function render(): View
    {
        return view('livewire.author-show-live');
    }
}
