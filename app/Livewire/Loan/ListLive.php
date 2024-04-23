<?php

namespace App\Livewire\Loan;

use App\Enums\LoanStatusEnum;
use App\Models\Loan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
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

    #[Locked]
    public $loan_id;

    public $loan_status;

    public $devolution_date;

    public $copy_status;

    public function mount(): void
    {
        $this->devolution_date = now()->format('d/m/Y');
    }

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

    public function setLoan(string $id): void
    {
        $this->loan_id = $id;

        $this->dispatch('show-edit-status-' . $id)->self();
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
        $loans = Loan::select('id', 'copy_id', 'user_id', 'start_date', 'limit_date', 'devolution_date', 'is_fineable', 'fine_amount', 'status')
            ->with([
                'copy:id,edition_id,identifier,is_loanable,status',
                'copy.edition:id,book_id,editorial_id',
                'copy.edition.book:id,title,author_id',
                'copy.edition.editorial:id,name',
                'copy.edition.book.author:id,firstname,lastname,pseudonym',
                'user:id,name,email',
                'user.profile:id,user_id,document_type_id,document_number,phone',
                'user.profile.document_type:id,name,abbreviation',
            ])
            ->when($this->statusesArray, function ($query) {
                $query->whereIn('status', $this->statusesArray);
            })
            ->where(function ($query) {
                $query->whereHas('copy', function ($query) {
                    $query->where('copies.identifier', 'like', '%' . $this->search . '%')
                        ->orWhereHas('edition', function ($query) {
                            $query->whereRelation('book', 'books.title', 'like', '%' . $this->search . '%')
                                ->orWhereRelation('editorial', 'editorials.name', 'like', '%' . $this->search . '%')
                                ->orWhereHas('book', function ($query) {
                                    $query->whereRelation('author', 'firstname', 'like', '%' . $this->search . '%')
                                        ->orWhereRelation('author', 'lastname', 'like', '%' . $this->search . '%')
                                        ->orWhereRelation('author', 'pseudonym', 'like', '%' . $this->search . '%');
                                });
                        });
                })->orWhereHas('user', function ($query) {
                    $query->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByRaw("
                CASE
                    WHEN status = '". LoanStatusEnum::EN_CURSO->value ."' THEN 1
                    WHEN status = '". LoanStatusEnum::COMPLETADO->value ."' THEN 2
                    WHEN status = '". LoanStatusEnum::CANCELADO->value ."' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('start_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.loan.list-live', [
            'loans' => $loans,
        ]);
    }
}
