<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Comment;


class ReplyComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'comment_reply_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    public function replyComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_reply_id', 'comments.id');
    }
}
