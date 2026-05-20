<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Borrowing extends Model
{
    protected $fillable = ['book_id', 'borrower_name', 'borrowed_at', 'due_date', 'returned_at'];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isReturned(): bool
    {
        return $this->returned_at !== null;
    }

    public function isOverdue(): bool
    {
        return !$this->isReturned() && $this->due_date->isPast();
    }

    public function overdueDays(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return (int) $this->due_date->diffInDays(Carbon::today());
    }
}
