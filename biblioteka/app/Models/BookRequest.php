<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookRequest extends Model
{
    protected $fillable = ['book_id', 'reader_name', 'contact', 'notes', 'status'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'na čekanju';
    }

    public function isApproved(): bool
    {
        return $this->status === 'odobreno';
    }
}
