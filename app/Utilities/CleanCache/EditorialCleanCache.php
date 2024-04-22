<?php

namespace App\Utilities\CleanCache;

use App\Models\Editorial;

class EditorialCleanCache extends CleanCacheBase
{
    protected $tag = 'editorial';

    public function __construct(
        public Editorial $editorial
    ) {}

    public function handle()
    {
        $this->flushCollections();

        $this->editorial->load('editions');

        $this->editorial->editions
            ->each(fn ($edition) => cache()->tags(["edition-{$edition->slug}"])->flush());
    }
}
