<?php

namespace App\Livewire\Editorial;

use App\Livewire\Forms\EditorialForm;
use App\Models\Editorial;
use App\Traits\HasSort;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public EditorialForm $form;

    public array $sortableColumns = ['name', 'slug'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('close-create-editorial');
        $this->dispatch('new-alert', message: 'Editorial agregada con éxito', type: 'success');
    }

    public function showDialog(): void
    {
        $this->form->resetForm();

        $this->dispatch('show-create-editorial')->self();
    }

    #[Computed]
    public function editorialsCount(): int
    {
        return Editorial::count();
    }

    #[Computed]
    public function editorials(): LengthAwarePaginator
    {
        return Editorial::select(['id', 'name', 'slug'])
            ->search($this->search)
            ->orderByColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);
    }
}
