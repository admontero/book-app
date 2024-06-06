<?php

namespace App\Models;

use App\Utilities\CleanCache\BookCleanCache;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookPseudonym extends Pivot
{
    protected $table = 'book_pseudonym';

    protected static function booted(): void
    {
        static::created(function (BookPseudonym $bookPseudonym) {
            (new BookCleanCache($bookPseudonym->pivotParent))->handle();
        });

        static::deleted(function (BookPseudonym $bookPseudonym) {
            (new BookCleanCache($bookPseudonym->pivotParent))->handle();
        });
    }
}
