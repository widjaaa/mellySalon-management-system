<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
