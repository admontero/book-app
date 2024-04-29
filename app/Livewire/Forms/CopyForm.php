<?php

namespace App\Livewire\Forms;

use App\Enums\CopyStatusEnum;
use App\Models\Copy;
use App\Models\Edition;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CopyForm extends Form
{
    public ?Copy $copy = null;

    public $identifier;

    public $edition_id;

    public bool $is_loanable = true;

    public $status = 'disponible';

    public bool $is_retired = false;

    public array $editions = [];

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
            'status' => [
                Rule::enum(CopyStatusEnum::class),
            ],
            'is_loanable' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'edition_id' => 'edición',
            'identifier' => 'identificación',
            'status' => 'estado',
            'is_loanable' => 'prestabilidad',
        ];
    }

    public function setIsRetired(string $value = ''): void
    {
        if ($value !== CopyStatusEnum::RETIRADA->value) {
            $this->is_retired = false;

            return ;
        }

        $this->is_retired = true;
    }

    public function loadEditions(): void
    {
        $this->editions = Edition::select([
                'editions.id as value',
                'books.title as label',
                DB::raw('CONCAT_WS(" • ", IF(editions.isbn13, editions.isbn13, null), editorials.name) as description')
            ])
            ->join('books', 'editions.book_id', '=', 'books.id')
            ->join('editorials', 'editions.editorial_id', '=', 'editorials.id')
            ->orderBy('editions.id', 'DESC')
            ->get()
            ->toArray();
    }

    public function setCopy(Copy $copy): void
    {
        $this->copy = $copy;

        $this->fill($copy);
    }

    public function save(): void
    {
        $this->validate();

        if ($this->status == CopyStatusEnum::RETIRADA->value) $this->is_loanable = false;

        if ($this->copy) {
            $this->copy->update($this->only(['identifier', 'edition_id', 'is_loanable', 'status']));
        } else {
            Copy::create($this->only(['identifier', 'edition_id', 'is_loanable', 'status']));
        }
    }
}
