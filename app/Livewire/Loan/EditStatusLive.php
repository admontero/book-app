<?php

namespace App\Livewire\Loan;

use App\Enums\CopyStatusEnum;
use App\Enums\FineStatusEnum;
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

    public $copy_status;

    public $fine_status;

    public $is_copy_status_enabled = false;

    public $is_handling_fine = false;

    public function rules(): array
    {
        return [
            'loan_status' => [
                'required',
                Rule::enum(LoanStatusEnum::class),
            ],
            'copy_status' => [
                'nullable',
                Rule::requiredIf(fn() => $this->is_copy_status_enabled),
                Rule::enum(CopyStatusEnum::class),
            ],
            'fine_status' => [
                'nullable',
                Rule::requiredIf(fn() => $this->loan->is_overdue && $this->is_handling_fine),
                Rule::enum(FineStatusEnum::class),
            ]
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'loan_status' => 'estado del préstamo',
            'copy_status' => 'estado de la copia',
            'fine_status' => 'estado de la multa',
        ];
    }

    public function mount(): void
    {
        $this->loan->load([
            'fine',
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

    public function save(): void
    {
        $this->validate();

        $devolution_date = $this->loan_status == LoanStatusEnum::COMPLETADO->value ? today() : null;

        $this->loan->update([
            'devolution_date' => $devolution_date,
            'status' => $this->loan_status,
        ]);

        $this->loan->copy()->update([
            'status' => $this->is_copy_status_enabled ? $this->copy_status : CopyStatusEnum::DISPONIBLE->value,
        ]);

        if ($this->loan->is_overdue && $this->is_handling_fine) {
            $this->loan->fine()?->update(['status' => $this->fine_status]);
        }

        $this->dispatch('new-alert', message: 'Estado del préstamo actualizado con éxito', type: 'success');

        $this->dispatch('redirect');
    }

    public function render(): View
    {
        $loan_statuses = Arr::except(LoanStatusEnum::options(), LoanStatusEnum::EN_CURSO->value);

        $copy_statuses = Arr::except(CopyStatusEnum::options(), CopyStatusEnum::OCUPADA->value);

        $fine_statuses = Arr::except(FineStatusEnum::options(), FineStatusEnum::PENDIENTE->value);

        return view('livewire.loan.edit-status-live', [
            'loan_statuses' => $loan_statuses,
            'copy_statuses' => $copy_statuses,
            'fine_statuses' => $fine_statuses,
        ]);
    }
}
