<?php

namespace App\Livewire\Forms;

use App\Models\Book;
use App\Models\BookPseudonym;
use App\Models\Edition;
use App\Models\Editorial;
use App\Models\Pseudonym;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Form;

class EditionForm extends Form
{
    public ?Edition $edition = null;

    public $book_id;

    public $editorial_id;

    public $isbn13;

    public $year;

    public $pages;

    public $cover;

    public array $books = [];

    public array $editorials = [];

    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'exists:books,id',
            ],
            'editorial_id' => [
                'required',
                'exists:editorials,id',
            ],
            'isbn13' => [
                'nullable',
                'digits:13',
            ],
            'year' => [
                'nullable',
                'digits_between:0,4',
                'integer',
                'min:0',
                'max:' . now()->year,
            ],
            'pages' => [
                'nullable',
                'numeric',
                'min:1',
            ],
            'cover' => [
                'nullable',
                'image',
                'max:1024',
                'dimensions:min_width=300,min_height=450',
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'book_id' => 'libro',
            'editorial_id' => 'editorial',
            'year' => 'año',
            'pages' => 'páginas',
            'cover' => 'portada',
        ];
    }

    public function setEdition(Edition $edition): void
    {
        $this->edition = $edition;

        $this->fill($edition);
    }

    public function loadBooks(): void
    {
        $this->books = Book::query()
            ->leftJoin('book_pseudonym', 'books.id', '=', 'book_pseudonym.book_id')
            ->leftJoin('pseudonyms', 'book_pseudonym.pseudonym_id', '=', 'pseudonyms.id')
            ->select('books.id AS value', 'books.title AS label', DB::raw('GROUP_CONCAT(pseudonyms.name SEPARATOR ", ") AS description'))
            ->groupBy('books.id', 'books.title')
            ->orderBy('title')
            ->get()
            ->toArray();
    }

    public function loadEditorials(): void
    {
        $this->editorials = Editorial::select(['id as value','name as label'])
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function isThereAnOldCover(): bool
    {
        return $this->edition && $this->edition->cover_path && Storage::disk('public')->exists($this->edition->cover_path);
    }

    public function save(): void
    {
        $this->validate();

        if ($this->cover) {
            $name = Str::random(10) . '-' . time() . '.' . $this->cover->extension();

            $path = $this->cover->storeAs('covers', $name, 'public');

            if ($this->isThereAnOldCover()) {
                Storage::disk('public')->delete($this->edition->photo_path);
            }
        }

        $this->pages = is_numeric($this->pages) ? $this->pages : null;
        $this->year = $this->year ?: null;

        if ($this->edition) {
            $this->edition->update([
                ...$this->only(['book_id', 'editorial_id', 'isbn13', 'year', 'pages']),
                'cover_path' => isset($path) ? $path : $this->edition->cover_path,
            ]);
        } else {
            Edition::create([
                ...$this->only(['book_id', 'editorial_id', 'isbn13', 'year', 'pages']),
                'cover_path' => isset($path) ? $path : null,
            ]);
        }
    }
}
