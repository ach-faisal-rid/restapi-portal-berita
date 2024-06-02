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

    // update comment
    public function update(Request $request, $id) {
        $comment = Comment::findOrFail($id);

        // Check authorization
        if ($comment->user_id != Auth::id()) {
            return response()->json(['message' => 'You are not authorized to update this comment'], 403);
        }

        $validated = $request->validate([
            'comments_content' => 'required',
        ]);

        $comment->comments_content = $request->comments_content;
        $comment->save();

        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

}
