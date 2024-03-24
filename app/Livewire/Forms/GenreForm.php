<?php

namespace App\Livewire\Forms;

use App\Models\Genre;
use Illuminate\Validation\Rule;
use Livewire\Form;

class GenreForm extends Form
{
    public ?Genre $genre = null;

    public $name;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:30',
                Rule::unique('genres', 'name')->ignore($this->genre),
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'nombre',
        ];
    }

    public function setGenre(Genre $genre): void
    {
        $this->resetForm();

        $this->genre = $genre;

        $this->name = $genre->name;

        $this->resetErrorBag();
    }

    public function resetForm(): void
    {
        $this->resetErrorBag();

        $this->reset('genre', 'name');
    }

    public function save(): Genre
    {
        $this->validate();

        if ($this->genre) {
            $this->genre->update($this->only((['name'])));

            $genre = $this->genre->fresh();
        } else {
            $genre = Genre::create($this->only((['name'])));
        }

        $this->reset('genre');

        return $genre;
    }
}
