<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function document_type(): BelongsTo
    {
        return $this->BelongsTo(DocumentType::class, 'document_type_id');
    }
}
