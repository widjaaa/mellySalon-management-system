<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'tier',
        'bday',
        'poin',
        'total_visits',
        'total_spent'
    ];

    protected function casts(): array
    {
        return [
            'poin' => 'integer',
            'total_visits' => 'integer',
            'total_spent' => 'integer',
        ];
    }

    /**
     * Relasi ke semua transaksi milik member ini.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Hitung persentase diskon berdasarkan tier.
     */
    public function getDiscountPercent(): int
    {
        return match ($this->tier) {
            'Gold' => 10,
            'Silver' => 5,
            default => 0,
        };
    }
}
