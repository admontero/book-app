<?php

namespace App\Livewire\Genre;

use App\Livewire\Forms\GenreForm;
use App\Models\Genre;
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
    public string $search = '';

    public ?Genre $genre = null;

    public GenreForm $form;

    public array $sortableColumns = ['created_at', 'name', 'slug'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setGenre(string $id): void
    {
        $genre = $this->genres->firstWhere('id', $id);

        if (! $genre) abort(404);

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

    #[Computed]
    public function genres(): LengthAwarePaginator
    {
        return Genre::select(['id', 'name', 'slug'])
            ->search($this->search)
            ->orderbyColumn($this->sortColumn, $this->sortDirection)
            ->paginate(10);
    }
}
