<?php

namespace App\Models;

use App\Traits\OrderByColumnScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Author extends Model
{
    use HasFactory;
    use HasRelationships;
    use OrderByColumnScope;
    use Sluggable;

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
        'date_of_death' => 'date:Y-m-d',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['first_name', 'first_surname'],
            ]
        ];
    }

    public function editions(): HasManyDeep
    {
        return $this->hasManyDeep(Edition::class, [Pseudonym::class, 'book_pseudonym', Book::class]);
    }

    public function pseudonyms(): HasMany
    {
        return $this->hasMany(Pseudonym::class);
    }

    public function country_birth(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_birth_id');
    }

    public function state_birth(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_birth_id');
    }

    public function city_birth(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_birth_id');
    }

    protected function firstName(): Attribute
    {
        return Attribute::set(function (?string $value) {
            if (! $value) return ;

            return mb_strtolower($value);
        });
    }

    protected function middleName(): Attribute
    {
        return Attribute::set(function (?string $value) {
            if (! $value) return ;

            return mb_strtolower($value);
        });
    }

    protected function firstSurname(): Attribute
    {
        return Attribute::set(function (?string $value) {
            if (! $value) return ;

            return mb_strtolower($value);
        });
    }

    protected function secondSurname(): Attribute
    {
        return Attribute::set(function (?string $value) {
            if (! $value) return ;

            return mb_strtolower($value);
        });
    }

    public function photoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->photo_path
                    ? asset(Storage::url($this->photo_path))
                    : asset('dist/images/default.jpg');
        });
    }

    protected function placeOfBirth(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(', ', array_filter([
                    $this->city_birth?->name,
                    $this->state_birth?->name,
                    trans('world::country.' . $this->country_birth->iso2),
                ])),
        );
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('middle_name', 'like', '%' . $search . '%')
            ->orWhere('first_surname', 'like', '%' . $search . '%')
            ->orWhere('second_surname', 'like', '%' . $search . '%');
    }
}
