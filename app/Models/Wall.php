<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wall extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'userID1', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Wall_Like::class, 'wall_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Wall_Comment::class, 'wall_id', 'id');
    }
}
