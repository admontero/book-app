<?php

namespace App\Observers;

use App\Models\Genre;
use Illuminate\Support\Facades\Cache;

class GenreObserver
{
    protected $tag = 'genres';

    /**
     * Handle the Genre "created" event.
     */
    public function created(Genre $genre): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Genre "updated" event.
     */
    public function updated(Genre $genre): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Genre "deleted" event.
     */
    public function deleted(Genre $genre): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Genre "restored" event.
     */
    public function restored(Genre $genre): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Genre "force deleted" event.
     */
    public function forceDeleted(Genre $genre): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }
}
