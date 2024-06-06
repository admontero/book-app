<?php

namespace App\Models;

use App\Traits\OrderByColumnScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    use OrderByColumnScope;
    use Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function pseudonyms(): BelongsToMany
    {
        return $this->belongsToMany(Pseudonym::class,'book_pseudonym','book_id','pseudonym_id')
            ->using(BookPseudonym::class)
            ->withTimestamps();
    }

    public function editions(): HasMany
    {
        return $this->hasMany(Edition::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'book_genre','book_id','genre_id')
            ->using(BookGenre::class)
            ->withTimestamps();
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('title', 'like', '%' . $search . '%')
            ->orWhere('publication_year', 'like', '%' . $search . '%')
            ->orWhereRelation('pseudonyms', 'name', 'like', '%' . $search . '%');
    }
}
