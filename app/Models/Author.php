<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class Author extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
        'date_of_death' => 'date:Y-m-d',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
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

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => mb_strtolower($value),
        );
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

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date_of_birth->age . ' años',
        );
    }
}
