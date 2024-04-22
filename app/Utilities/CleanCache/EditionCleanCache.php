<?php

namespace App\Utilities\CleanCache;

use App\Models\Edition;

class EditionCleanCache extends CleanCacheBase
{
    protected $tag = 'edition';

    public function __construct(
        public Edition $edition
    ) {}

    public function handle()
    {
        $this->flushCollections();

        if (isset($this->edition->getChanges()['slug'])) {
            cache()->tags(["edition-{$this->edition->getOriginal('slug')}"])->flush();
        }

        cache()->tags(["edition-{$this->edition->slug}"])->flush();
    }
}
