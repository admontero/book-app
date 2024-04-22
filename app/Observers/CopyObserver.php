<?php

namespace App\Observers;

use App\Models\Copy;
use App\Utilities\CleanCache\CopyCleanCache;

class CopyObserver
{
    /**
     * Handle the Copy "created" event.
     */
    public function created(Copy $copy): void
    {
        (new CopyCleanCache($copy))->handle();
    }

    /**
     * Handle the Copy "updated" event.
     */
    public function updated(Copy $copy): void
    {
        (new CopyCleanCache($copy))->handle();
    }

    /**
     * Handle the Copy "deleted" event.
     */
    public function deleted(Copy $copy): void
    {
        (new CopyCleanCache($copy))->handle();
    }

    /**
     * Handle the Copy "restored" event.
     */
    public function restored(Copy $copy): void
    {
        (new CopyCleanCache($copy))->handle();
    }

    /**
     * Handle the Copy "force deleted" event.
     */
    public function forceDeleted(Copy $copy): void
    {
        (new CopyCleanCache($copy))->handle();
    }
}
