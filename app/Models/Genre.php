<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

use function Illuminate\Events\queueable;

class Genre extends Model
{
    use HasFactory;
    use HasRelationships;
    use Sluggable;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::created(queueable(function (Genre $genre) {
            Cache::tags('genres')->flush();
        }));

        static::updated(queueable(function (Genre $genre) {
            Cache::tags('genres')->flush();
        }));

        static::deleted(queueable(function (Genre $genre) {
            Cache::tags('genres')->flush();
        }));
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => mb_strtolower($value),
        );
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_genre', 'genre_id', 'book_id')->withTimestamps();
    }

    public function editions(): HasManyDeep
    {
        return $this->hasManyDeepFromRelations($this->books(), (new Book())->editions());
    }
}
