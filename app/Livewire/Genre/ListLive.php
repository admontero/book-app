<?php

namespace App\Livewire\Genre;

use App\Livewire\Forms\GenreForm;
use App\Models\Genre;
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
    public string $search = '';

    public ?Genre $genre = null;

    public GenreForm $form;

    public function mount(): void
    {
        $this->validateSorting(fields: ['id', 'name', 'slug']);
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setGenre(Genre $genre): void
    {
        $this->genre = $genre;

        $this->form->setGenre($genre);

        $this->dispatch('show-edit-genre-' . $genre->id)->self();
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('close-create-genre');
        $this->dispatch('new-alert', message: 'Género agregado con éxito', type: 'success');
    }

    public function update(): void
    {
        $this->form->save();

        $this->dispatch('genre-updated-' . $this->genre->id)->self();
        $this->dispatch('new-alert', message: 'Género actualizado con éxito', type: 'success');
    }

    public function showDialog(): void
    {
        $this->form->resetForm();

        $this->dispatch('show-create-genre')->self();
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

        return view('livewire.genre.list-live', [
            'genres' => $genres,
        ]);
    }
}
