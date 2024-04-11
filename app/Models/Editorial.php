<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

use function Illuminate\Events\queueable;

class Editorial extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::created(queueable(function (Editorial $editorial) {
            Cache::tags('editorials')->flush();
        }));

        static::updated(queueable(function (Editorial $editorial) {
            Cache::tags('editorials')->flush();
        }));

        static::deleted(queueable(function (Editorial $editorial) {
            Cache::tags('editorials')->flush();
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
            set: fn (string $value) => strtolower($value),
        );
    }

    public function editions(): HasMany
    {
        return $this->hasMany(Edition::class);
    }
}
