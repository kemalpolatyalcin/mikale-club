<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ClubTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'name',
        'section',
        'qr_token',
        'token_expires_at',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
        'token_expires_at' => 'datetime',
    ];

    public function generateTimedToken(?int $minutes = null): string
    {
        $duration = $minutes ?? config('mikale.token_expiration_minutes', 240);
        $newToken = 'qr-' . strtolower($this->table_number) . '-' . Str::random(12);
        
        $this->update([
            'qr_token' => $newToken,
            'token_expires_at' => now()->addMinutes($duration),
            'is_active' => true,
        ]);

        return $newToken;
    }

    public function isTokenValid(?string $token): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (empty($token) || $this->qr_token !== $token) {
            return false;
        }

        if ($this->token_expires_at && $this->token_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function expireToken(): void
    {
        $this->update([
            'token_expires_at' => now()->subMinute(),
            'qr_token' => 'qr-' . strtolower($this->table_number) . '-expired-' . Str::random(6),
        ]);
    }

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
