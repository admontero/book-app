<?php

namespace App\Livewire;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class AuthorEditLive extends Component
{
    use WithFileUploads;

    public Author $author;

    public $name;

    public $photo;

    public $date_of_birth;

    public $country_birth_id;

    public $state_birth_id;

    public $city_birth_id;

    public $date_of_death;

    public array $states = [];

    public array $cities = [];

    public $biography;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:100',
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

    public function mount(Author $author): void
    {
        $this->fill($author);

        $this->date_of_birth = $author->date_of_birth ? Carbon::parse($author->date_of_birth)->format('d/m/Y') : null;

        $this->date_of_death = $author->date_of_death ? Carbon::parse($author->date_of_death)->format('d/m/Y') : null;

        if (! $author->country_birth_id) return ;

        $this->setCountryBirthId($author->country_birth_id);

        if (! $author->state_birth_id) return ;

        $this->setStateBirthId($author->state_birth_id);

        if (! $author->city_birth_id) return ;

        $this->setCityBirthId($author->city_birth_id);
    }

    public function setCountryBirthId(int $value)
    {
        if (! $value) {
            $this->reset('country_birth_id', 'state_birth_id', 'city_birth_id', 'states', 'cities');

            return ;
        }

        $this->country_birth_id = $value;

        $this->states = State::where('country_id', $value)->orderBy('name')->get(['id', 'name'])->toArray();

        $this->reset('state_birth_id', 'city_birth_id');
    }

    public function setStateBirthId(int $value): void
    {
        if (! $value) {
            $this->reset('state_birth_id', 'city_birth_id', 'cities');

            return ;
        }

        $this->state_birth_id = $value;

        $this->cities = City::where('state_id', $value)->get(['id', 'name'])->toArray();

        $this->reset('city_birth_id');
    }

    public function setCityBirthId(int $value): void
    {
        if (! $value) {
            $this->reset('city_birth_id');

            return ;
        }

        $this->city_birth_id = $value;
    }

    public function save()
    {
        $this->validate();

        if ($this->photo) {
            $name = Str::slug($this->name) . '-' . time() . '.' . $this->photo->extension();

            $path = $this->photo->storeAs('authors', $name, 'public');

            if ($this->author->photo_path && Storage::disk('public')->exists($this->author->photo_path)) {
                Storage::disk('public')->delete($this->author->photo_path);
            }
        }

        $this->author->update([
            'name' => $this->name,
            'date_of_birth' => $this->date_of_birth ? Carbon::createFromFormat('d/m/Y', $this->date_of_birth) : null,
            'country_birth_id' => $this->country_birth_id,
            'state_birth_id' => $this->state_birth_id,
            'city_birth_id' => $this->city_birth_id,
            'date_of_death' => $this->date_of_death ? Carbon::createFromFormat('d/m/Y', $this->date_of_death) : null,
            'biography' => $this->biography,
            'photo_path' => isset($path) ? $path : $this->author->photo_path,
        ]);

        return $this->redirect(route('admin.authors.index'), navigate: true);
    }

    public function render()
    {
        $countries = Country::get(['id', 'iso2', 'name'])->transform(function(Country $country) {
            $country->name = trans('world::country.' . $country->iso2);

            return $country;
        });

        return view('livewire.author-edit-live', [
            'countries' => $countries,
        ]);
    }
}
