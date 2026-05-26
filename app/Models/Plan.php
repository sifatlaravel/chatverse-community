<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'code','name','bot_limit','site_limit','monthly_price_cents','currency','is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
