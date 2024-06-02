<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    // create new comment
    public function store(Request $request) {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comments_content' => 'required',
        ]);

        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = Auth::id();

        $comment->comments_content = $request->comments_content;
        $comment->save();

        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

}
