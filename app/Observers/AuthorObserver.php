<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class AuthorObserver
{
    protected $tag = 'authors';

    /**
     * Handle the Author "created" event.
     */
    public function created(Author $author): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Author "updated" event.
     */
    public function updated(Author $author): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Author "restored" event.
     */
    public function restored(Author $author): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Author "force deleted" event.
     */
    public function forceDeleted(Author $author): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }
}
