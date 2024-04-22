<?php

namespace App\Observers;

use App\Models\Book;
use App\Utilities\CleanCache\BookCleanCache;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        (new BookCleanCache($book))->handle();
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updated(Book $book): void
    {
        (new BookCleanCache($book))->handle();
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        (new BookCleanCache($book))->handle();
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        (new BookCleanCache($book))->handle();
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        (new BookCleanCache($book))->handle();
    }
}
