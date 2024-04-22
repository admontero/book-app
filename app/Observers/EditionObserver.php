<?php

namespace App\Observers;

use App\Models\Edition;
use App\Utilities\CleanCache\EditionCleanCache;

class EditionObserver
{
    /**
     * Handle the Edition "created" event.
     */
    public function created(Edition $edition): void
    {
        (new EditionCleanCache($edition))->handle();
    }

    /**
     * Handle the Edition "updated" event.
     */
    public function updated(Edition $edition): void
    {
        (new EditionCleanCache($edition))->handle();
    }

    /**
     * Handle the Edition "deleted" event.
     */
    public function deleted(Edition $edition): void
    {
        (new EditionCleanCache($edition))->handle();
    }

    /**
     * Handle the Edition "restored" event.
     */
    public function restored(Edition $edition): void
    {
        (new EditionCleanCache($edition))->handle();
    }

    /**
     * Handle the Edition "force deleted" event.
     */
    public function forceDeleted(Edition $edition): void
    {
        (new EditionCleanCache($edition))->handle();
    }
}
