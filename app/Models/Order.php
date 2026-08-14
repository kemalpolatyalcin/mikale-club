<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'club_table_id',
        'club_guest_id',
        'status',
        'total_amount',
        'guest_note',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(ClubTable::class, 'club_table_id');
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(ClubGuest::class, 'club_guest_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
