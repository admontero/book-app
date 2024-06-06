<?php

namespace App\Models;

use App\Enums\CopyStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Traits\OrderByColumnScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Copy extends Model
{
    use HasFactory;
    use OrderByColumnScope;

    protected $guarded = ['id'];

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function hasInProgressLoan(): bool
    {
        return $this->status == CopyStatusEnum::OCUPADA->value && $this->loans()->where('status', LoanStatusEnum::EN_CURSO->value)->exists();
    }

    protected function identifier(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }

    public function scopeInStatuses(Builder $query, array $statuses): void
    {
        $query->when($statuses, fn($query) => $query->whereIn('copies.status', $statuses));
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where(function ($query) use ($search) {
            $query->where('copies.identifier', 'like', '%' . $search . '%')
                ->orWhereHas('edition', function ($query) use ($search) {
                    $query->whereRelation('book', 'books.title', 'like', '%' . $search . '%')
                        ->orWhereRelation('editorial', 'editorials.name', 'like', '%' . $search . '%')
                        ->orWhereHas('book', function ($query) use ($search) {
                            $query->whereRelation('pseudonyms', 'name', 'like', '%' . $search . '%');
                        });
                });
        });
    }
}
