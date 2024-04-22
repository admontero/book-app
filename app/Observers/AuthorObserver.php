<?php

namespace App\Observers;

use App\Models\Author;
use App\Utilities\CleanCache\AuthorCleanCache;

class AuthorObserver
{
    /**
     * Handle the Author "created" event.
     */
    public function created(Author $author): void
    {
        (new AuthorCleanCache($author))->handle();
    }

    /**
     * Handle the Author "updated" event.
     */
    public function updated(Author $author): void
    {
        (new AuthorCleanCache($author))->handle();
    }

    /**
     * Handle the Author "deleted" event.
     */
    public function deleted(Author $author): void
    {
        (new AuthorCleanCache($author))->handle();
    }

    /**
     * Handle the Author "restored" event.
     */
    public function restored(Author $author): void
    {
        (new AuthorCleanCache($author))->handle();
    }

    /**
     * Handle the Author "force deleted" event.
     */
    public function forceDeleted(Author $author): void
    {
        (new AuthorCleanCache($author))->handle();
    }
}
