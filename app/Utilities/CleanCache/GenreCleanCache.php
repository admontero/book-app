<?php

namespace App\Utilities\CleanCache;

use App\Models\Genre;

class GenreCleanCache extends CleanCacheBase
{
    protected $tag = 'genre';

    public function __construct(
        public Genre $genre
    ) {}

    public function handle()
    {
        $this->flushCollections();

        $this->genre->load('editions');

        $this->genre->editions
            ->each(fn ($edition) => cache()->tags(["edition-{$edition->slug}"])->flush());
    }
}
