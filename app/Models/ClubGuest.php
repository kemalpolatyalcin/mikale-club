<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClubGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_code',
        'name',
        'phone',
        'club_table_id',
        'status',
        'check_in_at',
        'check_out_at',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(ClubTable::class, 'club_table_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function totalSpent(): float
    {
        return (float) $this->orders()->whereIn('status', ['pending', 'preparing', 'served', 'completed'])->sum('total_amount');
    }
}
