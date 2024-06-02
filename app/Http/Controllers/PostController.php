<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // list posts
    public function index() {
        $posts = Post::all();
        return PostResource::collection($posts);
    }

    // single page post
    public function show($id) {
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new PostDetailResource($post);
    }

    // create new post
    public function store(Request $request) {
        // dd($request->all());

        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id) {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => "Post with ID $id not found"], 404);
        }

        // Cek apakah pengguna memiliki izin untuk mengupdate post ini
        if ($post->author != Auth::user()->id) {
            return response()->json(['message' => "You are not authorized to update this post"], 403);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'news_content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update data post
        $post->title = $request->input('title');
        $post->news_content = $request->input('news_content');
        $post->save();

        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    // delete atau soft delete
    public function destroy($id) {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => "Post with ID $id not found"], 404);
        }

        // Cek apakah pengguna memiliki izin untuk menghapus post ini
        if ($post->author != Auth::user()->id) {
            return response()->json(['message' => "You are not authorized to delete this post"], 403);
        }

        // Hapus post
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

}
