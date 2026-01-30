<?php

// app/Models/Conversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [];

    /** Usuarios de la conversación */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /** Mensajes */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /** Último mensaje (muy útil para la sidebar) */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
