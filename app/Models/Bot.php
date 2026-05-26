<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bot extends Model
{
    protected $fillable = [
        'user_id','public_key','is_demo','bot_name','company_name','allowed_domain',
        'theme_primary','theme_accent','theme_bg','welcome_message','knowledge_base','is_active'
    ];

    protected $casts = [
        'is_demo' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }
}
