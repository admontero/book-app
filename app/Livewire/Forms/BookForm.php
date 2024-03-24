<?php

namespace App\Livewire\Forms;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Carbon\Carbon;
use Livewire\Form;

class BookForm extends Form
{
    public ?Book $book = null;

    public $title;

    public $publication_year;

    public $author_id;

    public $synopsis;

    public $genre_ids = [];

    public $authors = [];

    public $genres = [];

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

    public function loadGenres(): void
    {
        $this->genres = Genre::orderBy('name')->get(['id as value', 'name as label'])->toArray();
    }

    public function loadAuthors(): void
    {
        $this->authors = Author::orderBy('name')->get(['id as value', 'name as label'])->toArray();
    }

    public function setBook(Book $book): void
    {
        $this->book = $book;

        $this->fill($book);

        $this->genre_ids = $book->genres->pluck('id')->toArray();
    }

    public function setGenre(int $id): void
    {
        if (! $id) return ;

        if (in_array($id, $this->genre_ids)) {
            $this->genre_ids = array_values(array_filter($this->genre_ids, fn ($value) => $value !== $id));

            return ;
        }

        $this->genre_ids[] = $id;
        $this->genre_ids = array_values($this->genre_ids);
    }

    public function saveGenre(GenreForm $genreForm, string $name): void
    {
        $genreForm->name = $name;

        $genre = $genreForm->save();

        $this->genres = [...$this->genres, ['value' => $genre->id, 'label' => $genre->name]];

        $this->setGenre($genre->id);
    }

    public function save(): void
    {
        $this->validate();

        $this->publication_year = $this->publication_year ? Carbon::parse($this->publication_year)->format('Y') : null;
        $this->synopsis = $this->synopsis ? $this->synopsis : null;

        if ($this->book) {
            $this->book->update($this->only(['title', 'publication_year', 'author_id', 'synopsis']));
        } else {
            $this->book = Book::create($this->only(['title', 'publication_year', 'author_id', 'synopsis']));
        }

        $this->book->genres()->sync($this->genre_ids);
    }
}
