<?php

namespace App\Models;

use App\Enums\CopyStatusEnum;
use App\Filters\FilterBuilder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Edition extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['book.title', 'isbn13'],
            ]
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function editorial(): BelongsTo
    {
        return $this->belongsTo(Editorial::class, 'editorial_id');
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }

    public function enabledCopies(): HasMany
    {
        return $this->hasMany(Copy::class)
            ->whereIn('status', [CopyStatusEnum::DISPONIBLE->value, CopyStatusEnum::OCUPADA->value]);
    }

    public function coverUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->cover_path
                    ? asset(Storage::url($this->cover_path))
                    : asset('dist/images/default-edition.svg');
        });
    }

    public function scopeFilterBy($query, $filters)
    {
        $namespace = 'App\Filters\EditionFilters';

        $filter = new FilterBuilder($query, $filters, $namespace);

        return $filter->apply();
    }
}
