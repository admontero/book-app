<?php

namespace App\Livewire\Loan;

use App\Models\Loan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListLive extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: '')]
    public $statuses = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setStatuses(string $name): void
    {
        $statusesFilterArray = array_filter(explode(',', $this->statuses));

        if (in_array($name, $statusesFilterArray)) {
            $statusesFilterArray = array_diff($statusesFilterArray, [$name]);
        } else {
            $statusesFilterArray[] = $name;
        }

        $this->statuses = implode(',', $statusesFilterArray);
        $this->resetPage();
    }

    #[Computed]
    public function statusesArray(): array
    {
        return array_filter(explode(',', $this->statuses));
    }

    #[Computed]
    public function loansCount(): int
    {
        return Loan::count();
    }

    #[Computed]
    public function Loan(): Loan
    {
        return Loan::find($this->loan_id);
    }

    public function render()
    {
        $loans = Loan::select([
                'id',
                'copy_id',
                'user_id',
                'serial',
                'start_date',
                'limit_date',
                'devolution_date',
                'is_fineable',
                'fine_amount',
                'status'
            ])
            ->with([
                'copy:id,edition_id,identifier,is_loanable,status',
                'copy.edition:id,book_id,editorial_id',
                'copy.edition.book:id,title',
                'copy.edition.editorial:id,name',
                'copy.edition.book.pseudonyms:id,name,author_id',
                'user:id,name,email',
                'user.profile:id,user_id,document_type_id,document_number,phone',
                'user.profile.document_type:id,name,abbreviation',
            ])
            ->search($this->search)
            ->inStatuses($this->statusesArray)
            ->orderByStatus()
            ->orderBy('start_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.loan.list-live', [
            'loans' => $loans,
        ]);
    }
}
