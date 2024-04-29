<?php

namespace App\Livewire\Forms;

use App\Enums\CopyStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Models\Loan;
use Illuminate\Validation\Rule;
use Livewire\Form;

class LoanStatusForm extends Form
{
    public ?Loan $loan = null;

    public $loan_status;

    public $copy_status;

    public function rules(): array
    {
        return [
            'loan_status' => [
                'required',
                Rule::enum(LoanStatusEnum::class),
            ],
            'copy_status' => [
                'required',
                Rule::enum(CopyStatusEnum::class),
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'loan_status' => 'estado del préstamo',
            'copy_status' => 'estado de la copia',
        ];
    }

    public function setLoan(Loan $loan = null): void
    {
        $this->loan = $loan;
    }

    public function save(): void
    {
        $devolution_date = $this->loan_status == LoanStatusEnum::COMPLETADO->value ? today() : null;

        $this->loan->update([
            'devolution_date' => $devolution_date,
            'status' => $this->loan_status,
        ]);

        $this->loan->copy()->update([
            'status' => $this->copy_status,
        ]);

        if ($this->loan->status == LoanStatusEnum::CANCELADO->value) $this->loan->fine()?->delete();
    }
}
