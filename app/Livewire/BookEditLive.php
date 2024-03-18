<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Livewire\Component;

class BookEditLive extends Component
{
    public Book $book;

    public $title;

    public $publication_year;

    public $author_id;

    public $synopsis = '';

    public array $genre_ids = [];

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:2',
                'max:255',
            ],
            'publication_year' => [
                'nullable',
                'date_format:Y',
                'before_or_equal:' . now()->format('Y'),
            ],
            'author_id' => [
                'nullable',
                'exists:authors,id',
            ],
            'synopsis' => [
                'nullable',
                'max:800',
            ],
            'genre_ids' => [
                'required',
                'array',
                'min:1',
                'exists:genres,id',
            ],
        ];
    }

    public function mount(Book $book): void
    {
        $this->fill($book);

        $this->genre_ids = $book->genres->pluck('id')->toArray();
    }

    public function setGenreIds(int $id): void
    {
        if (! $id) return ;

        if (in_array($id, $this->genre_ids)) {
            $this->genre_ids = array_values(array_filter($this->genre_ids, fn ($value) => $value !== $id));

            return ;
        }

        $this->genre_ids[] = $id;
        $this->genre_ids = array_values($this->genre_ids);
    }

    public function save()
    {
        $this->validate();

        $this->book->update([
            'title' => $this->title,
            'publication_year' => $this->publication_year,
            'author_id' => $this->author_id,
            'synopsis' => $this->synopsis,
        ]);

        $this->book->genres()->sync($this->genre_ids);

        return $this->redirect(route('admin.books.index'), navigate: true);
    }

    public function render()
    {
        $authors = Author::orderBy('name')->get(['id', 'name']);

        $genres = Genre::orderBy('name')->get(['id','name']);

        return view('livewire.book-edit-live', [
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }
}
