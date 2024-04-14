<?php

namespace App\Observers;

use App\Models\Editorial;
use Illuminate\Support\Facades\Cache;

class EditorialObserver
{
    protected $tag = 'editorials';

    /**
     * Handle the Editorial "created" event.
     */
    public function created(Editorial $editorial): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Editorial "updated" event.
     */
    public function updated(Editorial $editorial): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Editorial "deleted" event.
     */
    public function deleted(Editorial $editorial): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Editorial "restored" event.
     */
    public function restored(Editorial $editorial): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Editorial "force deleted" event.
     */
    public function forceDeleted(Editorial $editorial): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }
}
