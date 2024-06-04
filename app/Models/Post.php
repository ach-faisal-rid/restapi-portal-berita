<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'image',
        'news_content',
        'author'
    ];

    public function writer() {
        return $this->belongsTo(User::class, 'author','id');
    }
    // Relasi ke user
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
