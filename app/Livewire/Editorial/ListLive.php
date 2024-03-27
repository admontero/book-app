<?php

namespace App\Livewire\Editorial;

use App\Livewire\Forms\EditorialForm;
use App\Models\Editorial;
use App\Traits\HasSort;
use Illuminate\View\View;
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

    public ?Editorial $editorial = null;

    public EditorialForm $form;

    public function mount(): void
    {
        $this->validateSorting(fields: ['name', 'slug']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setEditorial(Editorial $editorial): void
    {
        $this->editorial = $editorial;

        $this->form->setEditorial($editorial);

        $this->dispatch('show-edit-editorial-' . $editorial->id)->self();
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('close-create-editorial');
        $this->dispatch('new-alert', message: 'Editorial agregada con éxito', type: 'success');
    }

    public function update(): void
    {
        $this->form->save();

        $this->dispatch('editorial-updated-' . $this->editorial->id)->self();
        $this->dispatch('new-alert', message: 'Editorial actualizada con éxito', type: 'success');
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

    public function render(): View
    {
        $editorials = Editorial::select('id', 'name', 'slug')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.editorial.list-live', [
            'editorials' => $editorials,
        ]);
    }
}
