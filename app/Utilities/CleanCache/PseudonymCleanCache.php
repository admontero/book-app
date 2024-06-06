<?php

namespace App\Utilities\CleanCache;

use App\Models\Pseudonym;

class PseudonymCleanCache extends CleanCacheBase
{
    protected $tag = 'pseudonym';

    public function __construct(
        public Pseudonym $pseudonym
    ) {}

    public function handle()
    {
        $this->flushCollections();

        $this->pseudonym->load('editions');

        $this->pseudonym->editions
            ->each(fn ($edition) => cache()->tags(["edition-{$edition->slug}"])->flush());
    }
}
