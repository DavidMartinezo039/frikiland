<?php

// app/Models/Conversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany};
use Illuminate\Database\Eloquent\Builder;

class Conversation extends Model
{
    protected $fillable = [
        'status',
        'initiator_id'
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    /** Usuarios de la conversación */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function chatRequest()
    {
        return $this->hasOne(ChatRequest::class);
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

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function scopeVisibleFor(Builder $query, User $user): Builder
    {
        return $query->whereHas(
            'users',
            fn($q) =>
            $q->where('user_id', $user->id)
        )->where(function ($q) use ($user) {
            $q->where('status', 'active')->orWhere(function ($q) use ($user) {
                $q->where('status', 'pending')->whereHas(
                    'chatRequest',
                    fn($qr) =>
                    $qr->where('from_user_id', $user->id)
                );
            });
        });
    }
}
