<?php

namespace App\Utilities\CleanCache;

use App\Models\Author;

class AuthorCleanCache extends CleanCacheBase
{
    protected $tag = 'author';

    public function __construct(
        public Author $author
    ) {}

    public function handle()
    {
        $this->flushCollections();

        $this->author->load('editions');

        $this->author->editions
            ->each(fn ($edition) => cache()->tags(["edition-{$edition->slug}"])->flush());
    }
}
