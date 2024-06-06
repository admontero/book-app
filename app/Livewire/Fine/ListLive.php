<?php

namespace App\Livewire\Fine;

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
        $fines = Fine::select(['fines.id', 'fines.loan_id', 'fines.user_id', 'fines.days', 'fines.total', 'fines.status'])
            ->join('loans', 'loans.id', '=', 'fines.loan_id')
            ->with(['loan:id,copy_id,user_id,serial,start_date,limit_date,devolution_date,is_fineable,fine_amount,status'])
            ->search($this->search)
            ->inStatuses($this->statusesArray)
            ->orderByStatus()
            ->orderBy('loans.start_date', 'desc')
            ->orderBy('fines.id', 'desc')
            ->paginate(10);

        return view('livewire.fine.list-live', [
            'fines' => $fines,
        ]);
    }
}
