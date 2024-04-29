<?php

namespace App\Models;

use App\Enums\CopyStatusEnum;
use App\Enums\LoanStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Copy extends Model
{
    use HasFactory;

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
}
