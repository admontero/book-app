<?php

namespace App\Models;

use App\Utilities\CleanCache\BookCleanCache;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookGenre extends Pivot
{
    protected $table = 'book_genre';

    protected static function booted(): void
    {
        static::created(function (BookGenre $bookGenre) {
            (new BookCleanCache($bookGenre->pivotParent))->handle();
        });

        static::deleted(function (BookGenre $bookGenre) {
            (new BookCleanCache($bookGenre->pivotParent))->handle();
        });
    }
}
