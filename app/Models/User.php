<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'timezone',
        'is_admin',
        'is_suspended',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function bots()
    {
        return $this->hasMany(Bot::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_suspended' => 'boolean',
        ];
    }
}
