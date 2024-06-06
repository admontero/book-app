<?php

namespace App\Models;

use App\Traits\OrderByColumnScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Pseudonym extends Model
{
    use HasFactory;
    use HasRelationships;
    use OrderByColumnScope;
    use Sluggable;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::saving(function (Pseudonym $pseudonym) {
            $pseudonym->description = add_classes_to_html_content($pseudonym->description, 'text-gray-700 dark:text-gray-400');
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name'],
            ]
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'book_pseudonym','pseudonym_id','book_id')
            ->using(BookPseudonym::class)
            ->withTimestamps();
    }

    public function editions(): HasManyDeep
    {
        return $this->hasManyDeep(Edition::class, ['book_pseudonym', Book::class]);
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where(function ($query) use ($search) {
            $query->where('pseudonyms.name', 'like', '%' . $search . '%')
                ->orWhereRelation('author', 'authors.first_name', 'like', '%' . $search . '%')
                ->orWhereRelation('author', 'authors.middle_name', 'like', '%' . $search . '%')
                ->orWhereRelation('author', 'authors.first_surname', 'like', '%' . $search . '%')
                ->orWhereRelation('author', 'authors.second_surname', 'like', '%' . $search . '%')
                ->orWhereRelation('author', 'authors.full_name', 'like', '%' . $search . '%');
        });
    }
}
