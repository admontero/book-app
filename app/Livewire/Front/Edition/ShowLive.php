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
        $edition = Cache::tags(['editions-' . $this->slug])
            ->remember("{$this->getName()}-{$this->slug}", 3600, function() {
                return Edition::with([
                    'book:id,title,slug,synopsis,publication_year,author_id',
                    'book.genres:id,name,slug',
                    'book.author:id,firstname,lastname,pseudonym,slug,biography,photo_path',
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
