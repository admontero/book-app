<?php

namespace App\Livewire\Front\Edition;

use App\Models\Edition;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.front')]
class ShowLive extends Component
{
    public $slug;

    public function render()
    {
        $edition = Cache::tags(['edition-' . $this->slug])
            ->remember("{$this->getName()}-{$this->slug}", 3600, function() {
                return Edition::with([
                    'book:id,title,slug,synopsis,publication_year',
                    'book.genres:id,name,slug',
                    'book.pseudonyms:id,author_id,name,description',
                    'book.pseudonyms.author:id,first_name,middle_name,first_surname,second_surname,full_name,slug,photo_path',
                    'editorial:id,name,slug',
                ])
                    ->where('slug', $this->slug)
                    ->firstOrFail();
            });

        return view('livewire.front.edition.show-live', [
            'edition' => $edition,
            'back_url' => route('front.dashboard', ['page' => Session::has('page') ? Session::get('page') : null]),
        ]);
    }
}
