<?php

namespace App\Observers;

use App\Models\Copy;
use Illuminate\Support\Facades\Cache;

class CopyObserver
{
    protected $tag = 'copies';

    /**
     * Handle the Copy "created" event.
     */
    public function created(Copy $copy): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Copy "updated" event.
     */
    public function updated(Copy $copy): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Copy "deleted" event.
     */
    public function deleted(Copy $copy): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Copy "restored" event.
     */
    public function restored(Copy $copy): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Copy "force deleted" event.
     */
    public function forceDeleted(Copy $copy): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }
}
