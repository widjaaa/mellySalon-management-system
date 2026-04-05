<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'member_id', 'customer_name', 'services_summary', 
        'total_amount', 'payment_method', 'poin_awarded'
    ];
}
