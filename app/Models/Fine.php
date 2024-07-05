<?php

namespace App\Models;

use App\Enums\FineStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fine extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where(function ($query) use ($search) {
            $query->whereHas('loan', function ($query) use ($search) {
                $query->where('serial', 'like', '%' . $search . '%')
                    ->orWhereHas('copy', function ($query) use ($search) {
                        $query->where('copies.identifier', 'like', '%' . $search . '%')
                            ->orWhereHas('edition', function ($query) use ($search) {
                                $query->whereRelation('book', 'books.title', 'like', '%' . $search . '%')
                                    ->orWhereRelation('editorial', 'editorials.name', 'like', '%' . $search . '%')
                                    ->orWhereHas('book', function ($query) use ($search) {
                                        $query->whereRelation('pseudonyms', 'name', 'like', '%' . $search . '%');
                                    });
                            });
                    });
            })->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        });
    }

    public function scopeInStatuses(Builder $query, array $statuses): void
    {
        $query->when($statuses, function ($query) use ($statuses) {
            $query->whereIn('fines.status', $statuses);
        });
    }

    public function scopeOrderByStatus(Builder $query): void
    {
        $query->orderByRaw("
            CASE
                WHEN fines.status = '". FineStatusEnum::PENDIENTE->value ."' THEN 1
                WHEN fines.status = '". FineStatusEnum::PAGADA->value ."' THEN 2
                WHEN fines.status = '". FineStatusEnum::DESESTIMADA   ->value ."' THEN 3
                ELSE 4
            END
        ");
    }
}
