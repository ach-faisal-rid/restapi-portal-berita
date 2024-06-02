<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

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

    public function commentator() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
