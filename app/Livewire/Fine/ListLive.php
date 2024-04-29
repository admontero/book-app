<?php

namespace App\Livewire\Fine;

use App\Enums\FineStatusEnum;
use App\Models\Fine;
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
    public function finesCount(): int
    {
        return Fine::count();
    }

    public function render()
    {
        $fines = Fine::select('fines.id', 'fines.loan_id', 'fines.user_id', 'fines.days', 'fines.total', 'fines.status')
            ->join('loans', 'loans.id', '=', 'fines.loan_id')
            ->with('loan:id,copy_id,user_id,serial,start_date,limit_date,devolution_date,is_fineable,fine_amount,status')
            ->where(function ($query) {
                $query->whereHas('loan', function ($query) {
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
                });
            })
            ->orderByRaw("
                CASE
                    WHEN fines.status = '". FineStatusEnum::PENDIENTE->value ."' THEN 1
                    WHEN fines.status = '". FineStatusEnum::PAGADA->value ."' THEN 2
                    WHEN fines.status = '". FineStatusEnum::DESESTIMADA   ->value ."' THEN 3
                    ELSE 4
                END
            ")
            ->when($this->statusesArray, function ($query) {
                $query->whereIn('fines.status', $this->statusesArray);
            })
            ->orderBy('loans.start_date', 'desc')
            ->orderBy('fines.id', 'desc')
            ->paginate(10);

        return view('livewire.fine.list-live', [
            'fines' => $fines,
        ]);
    }
}
