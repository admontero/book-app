<?php

namespace App\Livewire\Loan;

use App\Enums\CopyStatusEnum;
use App\Enums\FineStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Livewire\Forms\FineStatusForm;
use App\Livewire\Forms\LoanStatusForm;
use App\Models\Loan;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Livewire\Component;

class ShowLive extends Component
{
    public Loan $loan;

    public LoanStatusForm $loan_status_form;

    public FineStatusForm $fine_status_form;

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
            'copy.edition.book.pseudonyms',
            'copy.edition.book.genres',
        ]);

        $this->loan_status_form->setLoan($this->loan);

        $this->fine_status_form->setFine($this->loan->fine);
    }

    public function saveLoan(): void
    {
        $this->loan_status_form->validate();

        $this->authorize('updateStatus', $this->loan);

        $this->loan_status_form->save();

        $this->loan->refresh();

        $this->dispatch('new-alert', message: 'Estado del préstamo actualizado con éxito', type: 'success');
    }

    public function saveFine(): void
    {
        $this->fine_status_form->validate();

        $this->authorize('updateStatus', $this->loan->fine);

        $this->fine_status_form->save();

        $this->loan->refresh();

        $this->dispatch('new-alert', message: 'Estado de la multa actualizado con éxito', type: 'success');
    }

    public function render(): View
    {
        $loan_statuses = Arr::except(LoanStatusEnum::options(), LoanStatusEnum::EN_CURSO->value);

        $copy_statuses = Arr::except(CopyStatusEnum::options(), CopyStatusEnum::OCUPADA->value);

        $fine_statuses = Arr::except(FineStatusEnum::options(), FineStatusEnum::PENDIENTE->value);

        return view('livewire.loan.show-live', [
            'loan_statuses' => $loan_statuses,
            'copy_statuses' => $copy_statuses,
            'fine_statuses' => $fine_statuses,
        ]);
    }
}
