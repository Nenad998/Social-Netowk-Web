<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class PostController extends Controller
{
    public function createNewPost(CreatePostRequest $request)
    {
        $user_id = Auth::user()->id;
        $content = $request->input('content');
        $post = new Post();
        $post->user_id = $user_id;
        $post->content = $content;
        $post->save();

        return Redirect::back()->with('createPost', 'Post successfully  created');
    }

    public function editPostView($postId)
    {
        $post = Post::findOrFail($postId);
        return response()->json($post);
    }

    public function editPost(Request $request)
    {
        $user_id = Auth::user()->id;
        $content = $request->input('content');

        $post = Post::find($request->id);
        $post->user_id = $user_id;
        $post->content = $content;
        $post->save();

        return response()->json($post);
    }

    public function deletePost(Request $request)
    {
        $id = $request->id;
        $post = Post::where('id', '=', $id)->first();
        $post->delete();

        return Redirect::back()->with('deletePost', 'Post successfully  deleted');
    }
}
