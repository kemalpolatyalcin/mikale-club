<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaiterCall extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_table_id',
        'club_guest_id',
        'order_id',
        'table_number',
        'guest_name',
        'guest_code',
        'type',
        'title',
        'message',
        'order_items',
        'total_amount',
        'status',
        'responded_at',
    ];

    protected $casts = [
        'order_items' => 'array',
        'total_amount' => 'decimal:2',
        'responded_at' => 'datetime',
    ];

    public function table()
    {
        return $this->belongsTo(ClubTable::class, 'club_table_id');
    }

    public function guest()
    {
        return $this->belongsTo(ClubGuest::class, 'club_guest_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
