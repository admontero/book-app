<?php

namespace App\Livewire\Forms;

use App\Enums\FineStatusEnum;
use App\Models\Fine;
use Illuminate\Validation\Rule;
use Livewire\Form;

class FineStatusForm extends Form
{
    public ?Fine $fine = null;

    public $fine_status;

    public function rules(): array
    {
        return [
            'fine_status' => [
                'required',
                Rule::enum(FineStatusEnum::class),
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'fine_status' => 'estado de la multa',
        ];
    }

    public function setFine(Fine $fine = null): void
    {
        $this->fine = $fine;
    }

    public function save(): void
    {
        $this->fine->update([
            'status' => $this->fine_status,
        ]);
    }
}
