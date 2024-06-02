<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comments_content',
    ];

    // Relasi ke post
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
