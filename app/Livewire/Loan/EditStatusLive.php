<?php

namespace App\Livewire\Loan;

use App\Enums\CopyStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class EditStatusLive extends Component
{
    public Loan $loan;

    public $loan_status;

    public $devolution_date;

    public $copy_status;

    public $is_copy_status_enabled = false;

    public function rules(): array
    {
        return [
            'loan_status' => [
                'required',
                Rule::enum(LoanStatusEnum::class),
            ],
            'devolution_date' => [
                'nullable',
                'date_format:d/m/Y',
                'after:' . $this->loan->start_date,
                Rule::requiredIf(fn() => $this->loan_status == LoanStatusEnum::COMPLETADO->value),
            ],
            'copy_status' => [
                'nullable',
                Rule::requiredIf(fn() => $this->is_copy_status_enabled),
                Rule::enum(CopyStatusEnum::class),
            ]
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'loan_status' => 'estado del préstamo',
            'devolution_date' => 'fecha de devolución',
            'copy_status' => 'estado de la copia',
        ];
    }

    public function mount(): void
    {
        $this->loan->load([
            'user',
            'user.profile',
            'user.profile.document_type',
            'copy',
            'copy.edition',
            'copy.edition.editorial',
            'copy.edition.book',
            'copy.edition.book.author',
            'copy.edition.book.genres',
        ]);
    }

    public function updatedLoanStatus($value): void
    {
        if ($value == LoanStatusEnum::COMPLETADO->value) {
            $this->devolution_date = today()->format('d/m/Y');

            return ;
        }
    }

    public function save(): void
    {
        $this->validate();

        $this->devolution_date = $this->devolution_date ? Carbon::createFromFormat('d/m/Y', $this->devolution_date) : null;

        $this->loan->update([
            'devolution_date' => $this->devolution_date,
            'status' => $this->loan_status,
        ]);

        $this->loan->copy()->update([
            'status' => $this->is_copy_status_enabled ? $this->copy_status : CopyStatusEnum::DISPONIBLE->value,
        ]);

        $this->redirect(route('back.loans.index'), navigate: true);
    }

    public function render(): View
    {
        $loan_statuses = Arr::except(LoanStatusEnum::options(), LoanStatusEnum::EN_CURSO->value);

        $copy_statuses = Arr::except(CopyStatusEnum::options(), CopyStatusEnum::OCUPADA->value);

        return view('livewire.loan.edit-status-live', [
            'loan_statuses' => $loan_statuses,
            'copy_statuses' => $copy_statuses,
        ]);
    }
}
