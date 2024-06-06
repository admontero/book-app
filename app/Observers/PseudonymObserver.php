<?php

namespace App\Observers;

use App\Models\Pseudonym;
use App\Utilities\CleanCache\PseudonymCleanCache;

class PseudonymObserver
{
    /**
     * Handle the Pseudonym "created" event.
     */
    public function created(Pseudonym $pseudonym): void
    {
        (new PseudonymCleanCache($pseudonym))->handle();
    }

    /**
     * Handle the Pseudonym "updated" event.
     */
    public function updated(Pseudonym $pseudonym): void
    {
        (new PseudonymCleanCache($pseudonym))->handle();
    }

    /**
     * Handle the Pseudonym "deleted" event.
     */
    public function deleted(Pseudonym $pseudonym): void
    {
        (new PseudonymCleanCache($pseudonym))->handle();
    }

    /**
     * Handle the Pseudonym "restored" event.
     */
    public function restored(Pseudonym $pseudonym): void
    {
        (new PseudonymCleanCache($pseudonym))->handle();
    }

    /**
     * Handle the Pseudonym "force deleted" event.
     */
    public function forceDeleted(Pseudonym $pseudonym): void
    {
        (new PseudonymCleanCache($pseudonym))->handle();
    }
}
