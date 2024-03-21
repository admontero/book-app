<?php

namespace App\Livewire;

use App\Enums\CopyStatusEnum;
use App\Models\Copy;
use App\Models\Edition;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CopyCreateLive extends Component
{
    public $identifier;

    public $edition_id;

    public bool $is_loanable = true;

    public $status = 'disponible';

    public function rules(): array
    {
        return [
            'identifier' => [
                'required',
                'string',
            ],
            'edition_id' => [
                'required',
                'exists:editions,id',
            ],
            'is_loanable' => [
                'nullable',
                'boolean',
            ],
            'status' => [
                'nullable',
                Rule::enum(CopyStatusEnum::class),
            ],
        ];
    }

    public function save()
    {
        $this->validate();

        Copy::create([
            'identifier' => $this->identifier,
            'edition_id' => $this->edition_id,
            'is_loanable' => $this->is_loanable,
            'status' => $this->status,
        ]);

        return $this->redirect(route('admin.copies.index'), navigate: true);
    }

    public function render()
    {
        $editions = Edition::select(['editions.id', 'books.title', DB::raw('CONCAT(editions.isbn13, " • ", editorials.name) as description')])
            ->join('books', 'editions.book_id', '=', 'books.id')
            ->join('editorials', 'editions.editorial_id', '=', 'editorials.id')
            ->orderBy('id', 'DESC')
            ->get();

        return view('livewire.copy-create-live', [
            'editions' => $editions,
        ]);
    }
}
