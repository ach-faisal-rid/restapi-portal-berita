<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    // list posts
    public function index() {
        $posts = Post::all();
        return PostResource::collection($posts);
    }
}
