<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\ReplyComment;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'home_page',
        'comment_text',
        'txt_file',
        'photo_file',
        'user_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function savedComments(): HasMany{
        return $this->hasMany(Comment::class);
    }

    public function replyComments(): HasMany{
        return $this->hasMany(ReplyComment::class);
    }
}
