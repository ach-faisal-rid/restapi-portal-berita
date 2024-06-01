<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // list posts
    public function index() {
        $posts = Post::all();
        return response()->json([
            'data' => $posts
        ]);
    }
}
