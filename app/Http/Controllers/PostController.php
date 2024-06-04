<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostDetailResource;

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

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/posts'); // Simpan gambar dalam direktori 'public/posts'
        }

        $requestData = $request->all();
        $request['author'] = Auth::user()->id;
        $requestData['image'] = $imagePath;

        $post = Post::create($requestData);
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Jika ada perubahan gambar
        if ($request->hasFile('image')) {
            // Menghapus gambar lama jika ada
            if ($post->image) {
                Storage::delete($post->image);
            }

            // Menyimpan gambar baru
            $imagePath = $request->file('image')->store('public/posts');
            $post->image = $imagePath;
        }

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
        $post = Post::withTrashed()->find($id);

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
