<?php

namespace App\Livewire;

use App\Models\Editorial;
use App\Traits\HasSort;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class EditorialListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public ?Editorial $editorial = null;

    public string $name = '';

    public function mount(): void
    {
        $this->validateSorting(fields: ['name', 'slug']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:50',
            ],
        ];
    }

    public function setEditorial(Editorial $editorial): void
    {
        $this->editorial = $editorial;

        $this->name = $editorial->name;

        $this->resetErrorBag();

        $this->dispatch('show-edit-editorial-' . $editorial->id)->self();
    }

    public function save(): void
    {
        $this->validate();

        Editorial::create([
            'name' => $this->name,
        ]);

        $this->dispatch('close-create-editorial');
        $this->dispatch('new-alert', message: 'Editorial agregada con éxito', type: 'success');
    }

    public function update(): void
    {
        if (! $this->editorial) return ;

        $this->validate();

        $this->editorial->update([
            'name' => $this->name,
        ]);

        $this->dispatch('editorial-updated-' . $this->editorial->id)->self();
        $this->dispatch('new-alert', message: 'Editorial actualizada con éxito', type: 'success');
    }

    public function resetValidation($field = null): void
    {
        parent::resetValidation($field);

        $this->dispatch('validation-errors-cleared')->self();
    }

    #[Computed]
    public function editorialsCount(): int
    {
        return Editorial::count();
    }

    public function render()
    {
        $editorials = Editorial::select('id', 'name', 'slug')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.editorial-list-live', [
            'editorials' => $editorials,
        ]);
    }
}
