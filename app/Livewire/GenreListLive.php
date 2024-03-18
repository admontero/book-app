<?php

namespace App\Livewire;

use App\Models\Genre;
use App\Traits\HasSort;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class GenreListLive extends Component
{
    use HasSort;
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public ?Genre $genre = null;

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
                'max:30',
                Rule::unique('genres', 'name')->ignore($this->genre),
            ],
        ];
    }

    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;

        $this->name = $genre->name;

        $this->resetErrorBag();

        $this->dispatch('show-edit-genre-' . $genre->id)->self();
    }

    public function save(): void
    {
        $this->validate();

        Genre::create([
            'name' => $this->name,
        ]);

        $this->dispatch('close-create-genre');
        $this->dispatch('new-alert', message: 'Género agregado con éxito', type: 'success');
    }

    public function update(): void
    {
        if (! $this->genre) return ;

        $this->validate();

        $this->genre->update([
            'name' => $this->name,
        ]);

        $this->dispatch('genre-updated-' . $this->genre->id)->self();
        $this->dispatch('new-alert', message: 'Género actualizado con éxito', type: 'success');
    }

    public function resetValidation($field = null): void
    {
        parent::resetValidation($field);

        $this->dispatch('validation-errors-cleared')->self();
    }

    #[Computed]
    public function genresCount(): int
    {
        return Genre::count();
    }

    public function render(): View
    {
        $genres = Genre::select('id', 'name', 'slug')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.genre-list-live', [
            'genres' => $genres,
        ]);
    }
}
