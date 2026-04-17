<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'service_name',
        'service_price',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'service_price' => 'integer',
            'quantity' => 'integer',
        ];
    }

    /**
     * Relasi ke transaksi induk.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
