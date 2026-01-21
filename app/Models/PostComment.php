<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class PostComment extends Model
{
    use HasFactory;

    protected $casts = [
        'media' => 'array',
    ];

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'media',
        'likes_count',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(PostComment::class, 'parent_id')
            ->latest();
    }

    public function likedBy()
    {
        return $this->belongsToMany(
            User::class,
            'post_comment_likes'
        )->withTimestamps();
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likedBy()->where('user_id', $user->id)->exists();
    }
}
