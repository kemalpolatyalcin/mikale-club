<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_number',
        'club_guest_id',
        'club_table_id',
        'subtotal',
        'service_fee',
        'discount',
        'total_amount',
        'payment_method',
        'status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function guest(): BelongsTo
    {
        return $this->belongsTo(ClubGuest::class, 'club_guest_id');
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(ClubTable::class, 'club_table_id');
    }
}
