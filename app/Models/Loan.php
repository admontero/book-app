<?php

namespace App\Models;

use App\Enums\LoanStatusEnum;
use App\Jobs\GenerateLoanSerialJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'limit_date' => 'date',
        'devolution_date' => 'date',
    ];

    protected $appends = [
        'is_overdue',
    ];

    protected static function booted(): void
    {
        static::created(function (Loan $loan) {
            GenerateLoanSerialJob::dispatch($loan->id);
        });
    }

    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copy::class, 'copy_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class);
    }

    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->devolution_date?->isAfter($this->limit_date)) return true;

                if ($this->status === LoanStatusEnum::EN_CURSO->value && Carbon::parse(today()->toDateString())->isAfter($this->limit_date)) return true;

                return false;
            },
        );
    }

    public function isFined(): Bool
    {
        return $this->is_fineable && $this->is_overdue;
    }
}
