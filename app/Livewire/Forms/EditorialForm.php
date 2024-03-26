<?php

namespace App\Livewire\Forms;

use App\Models\Editorial;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditorialForm extends Form
{
    public ?Editorial $editorial = null;

    public $name;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:50',
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'name' => 'nombre',
        ];
    }

    public function setEditorial(Editorial $editorial): void
    {
        $this->resetForm();

        $this->editorial = $editorial;

        $this->name = $editorial->name;

        $this->resetErrorBag();
    }

    public function resetForm(): void
    {
        $this->resetErrorBag();

        $this->reset('editorial', 'name');
    }

    public function save(): Editorial
    {
        $this->validate();

        if ($this->editorial) {
            $this->editorial->update($this->only((['name'])));

            $editorial = $this->editorial->fresh();
        } else {
            $editorial = Editorial::create($this->only((['name'])));
        }

        $this->reset('editorial');

        return $editorial;
    }
}
