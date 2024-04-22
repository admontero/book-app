<?php

namespace App\Utilities\CleanCache;

use App\Models\Copy;

class CopyCleanCache extends CleanCacheBase
{
    protected $tag = 'copy';

    public function __construct(
        public Copy $copy
    ) {}

    public function handle()
    {
        $this->flushCollections();
    }
}
