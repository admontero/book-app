<?php

namespace App\Livewire\Loan;

use App\Enums\CopyStatusEnum;
use App\Enums\RoleEnum;
use App\Events\LoanCreated;
use App\Models\Copy;
use App\Models\Loan;
use App\Models\User;
use App\Rules\CopyMustBeAvailable;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class CreateLive extends Component
{
    use WithPagination;

    public int $step = 1;

    public $user_id;

    public $copy_id;

    public $limit_date;

    public $is_fineable = false;

    public $fine_amount;

    public $search = '';

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'copy_id' => 'required|exists:copies,id',
            'limit_date' => 'date_format:d/m/Y|after:today',
            'is_fineable' => 'required|boolean',
            'fine_amount' => [
                'nullable',
                Rule::requiredIf(fn() => $this->is_fineable),
                'regex:/^\d+(\.\d{1})?$/',
            ],
        ];
    }

    public function data(): array
    {
        return [
            'user_id' => $this->user_id,
            'copy_id' => $this->copy_id,
            'limit_date' => $this->limit_date,
            'is_fineable' => $this->is_fineable,
            'fine_amount' => $this->fine_amount,
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'user_id' => 'lector',
            'copy_id' => 'libro',
            'limit_date' => 'fecha límite de devolución',
            'is_fineable' => 'es multable',
            'fine_amount' => 'monto acumulable diario',
        ];
    }

    public function messages(): array
    {
        return [
            'limit_date.after' => 'La :attribute debe ser una fecha posterior a hoy',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage('usersPage');

        $this->resetPage('copiesPage');
    }

    public function updatedUserId(): void
    {
        $this->resetPage('usersPage');
    }

    public function updatedCopyId(): void
    {
        $this->resetPage('copiesPage');
    }

    public function resetForm(): void
    {
        $this->reset(['step', 'user_id', 'copy_id', 'limit_date', 'is_fineable', 'fine_amount', 'search']);

        $this->resetPage('usersPage');

        $this->resetPage('copiesPage');

        $this->step = 1;
    }

    public function setStep(int $step = null): void
    {
        if (! $step) return ;

        $valid_steps = [1, 2, 3, 4];

        if (! in_array($step, $valid_steps)) {

            $this->reset('step', 'search');

            return ;
        }

        if ($step == 2) {
            $this->validate(Arr::only($this->rules(), ['user_id']));
        }

        if ($step == 3) {
            $this->validate(Arr::only($this->rules(), ['copy_id']));
        }

        if ($step == 4) {
            $this->validate(Arr::except($this->rules(), ['user_id', 'copy_id']));
        }

        $this->step = $step;

        $this->reset('search');
    }

    public function save(): void
    {
        $this->validate();

        $validator = Validator::make(
            Arr::only($this->data(), ['copy_id']),
            ['copy_id' => new CopyMustBeAvailable],
        );

        if ($validator->fails()) {
            $this->step = 2;

            $this->reset(['copy_id', 'limit_date', 'is_fineable', 'fine_amount']);

            $this->addError('copy_unavailable', $validator->errors()->first());

            return ;
        }

        $this->limit_date = $this->limit_date ? Carbon::createFromFormat('d/m/Y', $this->limit_date) : null;

        $loan = Loan::create([
            'user_id' => $this->user_id,
            'copy_id' => $this->copy_id,
            'start_date' => now(),
            'limit_date' => $this->limit_date,
            'is_fineable' => $this->is_fineable,
            'fine_amount' => $this->is_fineable ? $this->fine_amount : null,
        ]);

        LoanCreated::dispatch($loan);

        $this->resetForm();

        $this->dispatch('new-alert', message: 'Préstamo registrado con éxito', type: 'success');

        $this->dispatch('redirect');
    }

    #[Computed]
    public function stepOneCompleted(): bool
    {
        $validator = Validator::make(
            Arr::only($this->data(), ['user_id']),
            Arr::only($this->rules(), ['user_id']),
        );

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function stepTwoCompleted(): bool
    {
        $validator = Validator::make(
            Arr::only($this->data(), ['copy_id']),
            Arr::only($this->rules(), ['copy_id']),
        );

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function stepThreeCompleted(): bool
    {
        $validator = Validator::make(
            Arr::except($this->data(), ['user_id', 'copy_id']),
            Arr::except($this->rules(), ['user_id', 'copy_id']),
        );

        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    #[Computed]
    public function userSelected(): ?User
    {
        return User::select('id', 'name', 'email', 'profile_photo_path')
            ->with([
                'profile:id,user_id,document_type_id,document_number,phone',
                'profile.document_type:id,name,abbreviation',
            ])
            ->find($this->user_id);
    }

    #[Computed]
    public function totalUsers(): int
    {
        return User::whereHas('roles', function ($query) {
            $query->whereIn('name', [RoleEnum::LECTOR->value]);
        })->count();
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        return User::select('id', 'name', 'email', 'profile_photo_path')
            ->with([
                'profile:id,user_id,document_type_id,document_number,phone',
                'profile.document_type:id,name,abbreviation',
            ])
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', [RoleEnum::LECTOR->value]);
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest('id')
            ->paginate(6, ['*'], 'usersPage');
    }

    #[Computed]
    public function copySelected(): ?Copy
    {
        return Copy::select('id', 'edition_id', 'identifier')
            ->with([
                'edition:id,slug,isbn13,pages,year,cover_path,editorial_id,book_id',
                'edition.editorial:id,name,slug',
                'edition.book:id,title,slug,author_id',
                'edition.book.author:id,firstname,lastname,pseudonym,slug',
                'edition.book.genres:id,name,slug',
            ])
            ->find($this->copy_id);
    }

    #[Computed]
    public function totalCopies(): int
    {
        return Copy::where('is_loanable', 1)
            ->whereIn('status', [CopyStatusEnum::DISPONIBLE->value])
            ->count();
    }

    #[Computed]
    public function copies(): LengthAwarePaginator
    {
        return Copy::select('id', 'edition_id', 'identifier')
            ->with([
                'edition:id,slug,isbn13,pages,year,cover_path,editorial_id,book_id',
                'edition.editorial:id,name,slug',
                'edition.book:id,title,slug,author_id',
                'edition.book.author:id,firstname,lastname,pseudonym,slug',
                'edition.book.genres:id,name,slug',
            ])
            ->where('is_loanable', 1)
            ->whereIn('status', [CopyStatusEnum::DISPONIBLE->value])
            ->when($this->search, function ($query) {
                $query->where('identifier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('edition', function ($query) {
                        $query->where('isbn13', 'like', '%' . $this->search . '%')
                            ->orWhereRelation('book', 'books.title', 'like', '%' . $this->search . '%')
                            ->orWhereRelation('editorial', 'editorials.name', 'like', '%' . $this->search . '%')
                            ->orWhereHas('book', function ($query) {
                                $query->whereRelation('author', 'firstname', 'like', '%' . $this->search . '%')
                                    ->orWhereRelation('author', 'lastname', 'like', '%' . $this->search . '%')
                                    ->orWhereRelation('author', 'pseudonym', 'like', '%' . $this->search . '%');
                            });
                    });
            })
            ->latest('id')
            ->paginate(5, ['*'], 'copiesPage');
    }

    public function render(): View
    {
        return view('livewire.loan.create-live');
    }
}
