<?php

namespace App\Livewire\Forms;

use App\Models\Author;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class AuthorForm extends Form
{
    public ?Author $author = null;

    public $firstname;

    public $lastname;

    public $pseudonym;

    public $photo;

    public $date_of_birth;

    public $country_birth_id;

    public $state_birth_id;

    public $city_birth_id;

    public $date_of_death;

    public $countries = [];

    public $states = [];

    public $cities = [];

    public $biography = null;

    public function rules(): array
    {
        return [
            'firstname' => [
                'required',
                'max:60',
            ],
            'lastname' => [
                'required',
                'max:60',
            ],
            'pseudonym' => [
                'nullable',
                'max:60',
            ],
            'date_of_birth' => [
                'nullable',
                'date_format:d/m/Y',
                'before:' . now()->addDay()->format('d/m/Y'),
            ],
            'country_birth_id' => [
                'nullable',
                Rule::requiredIf(fn () => $this->state_birth_id),
                'exists:countries,id',
            ],
            'state_birth_id' => [
                'nullable',
                Rule::requiredIf(fn () => $this->city_birth_id),
                Rule::exists('states', 'id')->when($this->country_birth_id, fn ($query) => $query->where('country_id', $this->country_birth_id)),
            ],
            'city_birth_id' => [
                'nullable',
                Rule::exists('cities', 'id')->when($this->state_birth_id, fn ($query) => $query->where('state_id', $this->state_birth_id)),
            ],
            'date_of_death' => [
                'nullable',
                'date_format:d/m/Y',
                'after:date_of_birth',
                'before:' . now()->addDay()->format('d/m/Y'),
            ],
            'photo' => [
                'nullable',
                'image',
                'max:1024',
                'dimensions:min_width=300,min_height=300',
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'firstname' => 'nombre',
            'lastname' => 'apellido',
            'pseudonym' => 'seudónimo',
            'date_of_birth' => 'fecha de nacimiento',
            'country_birth_id' => 'país de nacimiento',
            'state_birth_id' => 'estado de nacimiento',
            'city_birth_id' => 'ciudad de nacimiento',
            'date_of_death' => 'fecha de defunción',
            'biography' => 'biografía',
        ];
    }

    public function setAuthor(Author $author): void
    {
        $this->author = $author;

        $this->fill($author);

        $this->date_of_birth = $author->date_of_birth ? Carbon::parse($author->date_of_birth)->format('d/m/Y') : null;

        $this->date_of_death = $author->date_of_death ? Carbon::parse($author->date_of_death)->format('d/m/Y') : null;

        if (! $author->country_birth_id) return ;

        $this->setCountryBirth($author->country_birth_id);

        if (! $author->state_birth_id) return ;

        $this->setStateBirth($author->state_birth_id);

        if (! $author->city_birth_id) return ;

        $this->setCityBirth($author->city_birth_id);
    }

    public function loadCountries(): void
    {
        $this->countries = Country::get(['id as value', 'name as label', 'iso2'])
            ->transform(function(Country $country) {
                $country->label = trans('world::country.' . $country->iso2);

                return $country;
            })
            ->toArray();
    }

    public function setCountryBirth(int $value): void
    {
        if (! $value) {
            $this->reset('country_birth_id', 'state_birth_id', 'city_birth_id', 'states', 'cities');

            return ;
        }

        if ($value != $this->country_birth_id) {
            $this->reset('country_birth_id', 'state_birth_id', 'city_birth_id', 'states', 'cities');
        }

        $this->country_birth_id = $value;

        $this->states = State::where('country_id', $value)->orderBy('name')->get(['id as value', 'name as label'])->toArray();

        $this->reset('state_birth_id', 'city_birth_id');

    }

    public function setStateBirth(int $value): void
    {
        if (! $value) {
            $this->reset('state_birth_id', 'city_birth_id', 'cities');

            return ;
        }

        if ($value != $this->state_birth_id) {
            $this->reset('state_birth_id', 'city_birth_id', 'cities');
        }

        $this->state_birth_id = $value;

        $this->cities = City::where('state_id', $value)->get(['id as value', 'name as label'])->toArray();

        $this->reset('city_birth_id');
    }

    public function setCityBirth(int $value): void
    {
        if (! $value) {
            $this->reset('city_birth_id');

            return ;
        }

        $this->city_birth_id = $value;
    }

    public function isThereAnOldPhoto(): bool
    {
        return $this->author && $this->author->photo_path && Storage::disk('public')->exists($this->author->photo_path);
    }

    public function save(): void
    {
        $this->validate();

        if ($this->photo) {
            $name = Str::random(10) . '-' . time() . $this->photo->extension();

            $path = $this->photo->storeAs('authors', $name, 'public');

            if ($this->isThereAnOldPhoto()) {
                Storage::disk('public')->delete($this->author->photo_path);
            }
        }

        $this->date_of_birth = $this->date_of_birth ? Carbon::createFromFormat('d/m/Y', $this->date_of_birth) : null;

        $this->date_of_death = $this->date_of_death ? Carbon::createFromFormat('d/m/Y', $this->date_of_death) : null;

        $this->pseudonym = $this->pseudonym ?: null;

        $this->formatBiography();

        if ($this->author) {
            $this->author->update([
                ...$this->only([
                    'firstname',
                    'lastname',
                    'pseudonym',
                    'date_of_birth',
                    'country_birth_id',
                    'state_birth_id',
                    'city_birth_id',
                    'date_of_death',
                    'biography'
                ]),
                'photo_path' => isset($path) ? $path : $this->author->photo_path,
            ]);
        } else {
            Author::create([
                ...$this->only([
                    'firstname',
                    'lastname',
                    'pseudonym',
                    'date_of_birth',
                    'country_birth_id',
                    'state_birth_id',
                    'city_birth_id',
                    'date_of_death',
                    'biography'
                ]),
                'photo_path' => isset($path) ? $path : null,
            ]);
        }
    }

    protected function formatBiography(): void
    {
        $classes = 'text-gray-700 dark:text-gray-400';

        $this->biography = preg_replace('/<(\w+)/', '<$1 class="' . $classes . '"', $this->biography);
    }
}
