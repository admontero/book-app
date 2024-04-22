<?php

namespace App\Observers;

use App\Models\Editorial;
use App\Utilities\CleanCache\EditorialCleanCache;

class EditorialObserver
{
    /**
     * Handle the Editorial "created" event.
     */
    public function created(Editorial $editorial): void
    {
        (new EditorialCleanCache($editorial))->handle();
    }

    /**
     * Handle the Editorial "updated" event.
     */
    public function updated(Editorial $editorial): void
    {
        (new EditorialCleanCache($editorial))->handle();
    }

    /**
     * Handle the Editorial "deleted" event.
     */
    public function deleted(Editorial $editorial): void
    {
        (new EditorialCleanCache($editorial))->handle();
    }

    /**
     * Handle the Editorial "restored" event.
     */
    public function restored(Editorial $editorial): void
    {
        (new EditorialCleanCache($editorial))->handle();
    }

    /**
     * Handle the Editorial "force deleted" event.
     */
    public function forceDeleted(Editorial $editorial): void
    {
        (new EditorialCleanCache($editorial))->handle();
    }
}
