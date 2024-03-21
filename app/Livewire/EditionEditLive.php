<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Edition;
use App\Models\Editorial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditionEditLive extends Component
{
    use WithFileUploads;

    public Edition $edition;

    public $book_id;

    public $editorial_id;

    public $isbn13;

    public $year;

    public $pages;

    public $cover;

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
                'required',
                'digits:13',
            ],
            'year' => [
                'nullable',
                'date_format:Y',
                'before_or_equal:' . now()->format('Y'),
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
                'dimensions:min_width=300,min_height=300',
            ],
        ];
    }

    public function mount(Edition $edition): void
    {
        $this->fill($edition);
    }

    public function save()
    {
        $this->validate();

        if ($this->cover) {
            $name = Str::slug($this->isbn13) . '-' . time() . '.' . $this->cover->extension();

            $path = $this->cover->storeAs('covers', $name, 'public');

            if ($this->edition->cover_path && Storage::disk('public')->exists($this->edition->cover_path)) {
                Storage::disk('public')->delete($this->edition->cover_path);
            }
        }

        $this->edition->update([
            'book_id' => $this->book_id,
            'editorial_id' => $this->editorial_id,
            'isbn13' => $this->isbn13,
            'year' => $this->year ? $this->year : null,
            'pages' => is_numeric($this->pages) ? $this->pages : null,
            'cover_path' => isset($path) ? $path : $this->edition->cover_path,
        ]);

        return $this->redirect(route('admin.editions.index'), navigate: true);
    }

    public function render()
    {
        $books = Book::orderBy('title')->get(['id', 'title']);

        $editorials = Editorial::orderBy('name')->get(['id','name']);

        return view('livewire.edition-edit-live', [
            'books' => $books,
            'editorials' => $editorials,
        ]);
    }
}
