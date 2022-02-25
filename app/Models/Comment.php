<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function users_comments()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comment_likes()
    {
        return $this->hasMany(Comment_Like::class, 'comment_id','id');
    }


}
