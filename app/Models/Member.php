<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

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
            'bday' => 'date',
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

    /**
     * Hitung ulang tier member berdasarkan total poin:
     * - \>= 10000 -> Gold
     * - \>= 5000 -> Silver
     * - < 5000 -> Bronze
     */
    public function updateTierBasedOnPoin(): void
    {
        if ($this->poin >= 10000) {
            $this->tier = 'Gold';
        } elseif ($this->poin >= 5000) {
            $this->tier = 'Silver';
        } else {
            $this->tier = 'Bronze';
        }
    }
}
