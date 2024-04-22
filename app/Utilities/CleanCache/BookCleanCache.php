<?php

namespace App\Utilities\CleanCache;

use App\Models\Book;

class BookCleanCache extends CleanCacheBase
{
    protected $tag = 'book';

    public function __construct(
        public Book $book
    ) {}

    public function handle()
    {
        $this->flushCollections();

        $this->book->load('editions');

        $this->book->editions
            ->each(fn ($edition) => cache()->tags(["edition-{$edition->slug}"])->flush());
    }
}
