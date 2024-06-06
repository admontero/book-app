<?php

namespace App\Livewire\Forms;

use App\Models\Author;
use App\Models\Pseudonym;
use Livewire\Form;

class PseudonymForm extends Form
{
    public ?Pseudonym $pseudonym = null;

    public $name;

    public $author_id;

    public $description = null;

    public $authors = [];

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
            ],
            'author_id' => [
                'nullable',
                'exists:authors,id',
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'author_id' => 'autor',
            'name' => 'nombre',
            'description' => 'descripción',
        ];
    }

    public function loadAuthors(): void
    {
        $this->authors = Author::select(['id as value', 'full_name as label'])
            ->orderBy('label')
            ->get()
            ->toArray();
    }

    public function setPseudonym(Pseudonym $pseudonym): void
    {
        $this->pseudonym = $pseudonym;

        $this->fill($pseudonym);
    }

    public function save(): void
    {
        $this->validate();

        $this->author_id = $this->author_id ?: null;

        $this->description = $this->description ?: null;

        if ($this->pseudonym) {
            $this->pseudonym->update([
                ...$this->only(['author_id', 'name', 'description']),
            ]);
        } else {
            Pseudonym::create([
                ...$this->only(['author_id', 'name', 'description']),
            ]);
        }
    }
}
