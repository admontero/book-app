<?php

namespace App\Observers;

use App\Models\Genre;
use App\Utilities\CleanCache\GenreCleanCache;

class GenreObserver
{
    /**
     * Handle the Genre "created" event.
     */
    public function created(Genre $genre): void
    {
        (new GenreCleanCache($genre))->handle();
    }

    /**
     * Handle the Genre "updated" event.
     */
    public function updated(Genre $genre): void
    {
        (new GenreCleanCache($genre))->handle();
    }

    /**
     * Handle the Genre "deleted" event.
     */
    public function deleted(Genre $genre): void
    {
        (new GenreCleanCache($genre))->handle();
    }

    /**
     * Handle the Genre "restored" event.
     */
    public function restored(Genre $genre): void
    {
        (new GenreCleanCache($genre))->handle();
    }

    /**
     * Handle the Genre "force deleted" event.
     */
    public function forceDeleted(Genre $genre): void
    {
        (new GenreCleanCache($genre))->handle();
    }
}
