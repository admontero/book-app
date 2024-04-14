<?php

namespace App\Livewire\Front;

use App\Models\Edition;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.front')]
class EditionShowLive extends Component
{
    public Edition $edition;

    public function mount()
    {
       $this->edition->load([
            'book:id,title,slug,synopsis,publication_year,author_id',
            'book.genres:id,name,slug',
            'book.author:id,firstname,lastname,pseudonym,slug,biography,photo_path',
            'editorial:id,name,slug',
        ]);
    }

    public function render()
    {
        return view('livewire.front.edition-show-live');
    }
}
