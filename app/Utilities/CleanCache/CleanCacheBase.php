<?php

namespace App\Utilities\CleanCache;

abstract class CleanCacheBase
{
    protected $tag = '';

    public function flushCollections(): void
    {
        $tags = array_map(fn($tag) => $tag['name'], array_filter(config('cache.tags'), fn ($tag) => in_array($this->tag, $tag['models'])));

        collect($tags)->each(fn ($tag) => cache()->tags($tag)->flush());
    }

    abstract public function handle();
}
