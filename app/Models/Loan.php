<?php

namespace App\Models;

use App\Enums\LoanStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function copy(): BelongsTo
    {
        return $this->belongsTo(Copy::class, 'copy_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
}
