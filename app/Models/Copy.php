<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Copy extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    protected function identifier(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtoupper($value),
        );
    }
}
