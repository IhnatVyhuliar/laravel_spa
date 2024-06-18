<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Comment;
use App\Models\User;

class SavedComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function comment():BelongsTo{
        return $this->belongsTo(Comment::class);
    }
}
