<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClubTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'name',
        'section',
        'qr_token',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    public function guests(): HasMany
    {
        return $this->hasMany(ClubGuest::class);
    }

    public function activeGuests(): HasMany
    {
        return $this->hasMany(ClubGuest::class)->where('status', 'active');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}
