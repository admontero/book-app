<?php

namespace App\Observers;

use App\Models\Edition;
use Illuminate\Support\Facades\Cache;

class EditionObserver
{
    protected $tag = 'editions';

    /**
     * Handle the Edition "created" event.
     */
    public function created(Edition $edition): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Edition "updated" event.
     */
    public function updated(Edition $edition): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());

        if (isset($edition->getChanges()['slug'])) {
            Cache::tags(["{$this->tag}-{$edition->getOriginal('slug')}"])->flush();
        }

        Cache::tags(["{$this->tag}-{$edition->slug}"])->flush();
    }

    /**
     * Handle the Edition "deleted" event.
     */
    public function deleted(Edition $edition): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Edition "restored" event.
     */
    public function restored(Edition $edition): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }

    /**
     * Handle the Edition "force deleted" event.
     */
    public function forceDeleted(Edition $edition): void
    {
        collect(config('cache.tags'))
            ->filter(fn($tag) => in_array($this->tag, $tag))
            ->each(fn ($tag) => Cache::tags($tag)->flush());
    }
}
