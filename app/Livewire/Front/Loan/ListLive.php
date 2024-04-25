<?php

namespace App\Livewire\Front\Loan;

use App\Enums\LoanStatusEnum;
use App\Models\Loan;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.front')]
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

    public function render()
    {
        $loans = Loan::select('id', 'copy_id', 'user_id', 'serial', 'start_date', 'limit_date', 'devolution_date', 'is_fineable', 'fine_amount', 'status')
            ->with([
                'fine',
                'copy:id,edition_id,identifier,is_loanable,status',
                'copy.edition:id,book_id,editorial_id',
                'copy.edition.book:id,title,author_id',
                'copy.edition.editorial:id,name',
                'copy.edition.book.author:id,firstname,lastname,pseudonym',
            ])
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('serial', 'like', '%' . $this->search . '%')
                    ->orWhereHas('copy', function ($query) {
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
                    });
            })
            ->when($this->statusesArray, function ($query) {
                $query->whereIn('status', $this->statusesArray);
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

        return view('livewire.front.loan.list-live', [
            'loans' => $loans,
        ]);
    }
}
