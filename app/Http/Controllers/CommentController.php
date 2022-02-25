<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function createNewComment(CreateCommentRequest $request)
    {
        $user_id = Auth::user()->id;
        $post_id = $request->post_id;
        $content = $request->input('comment');
        $comment = new Comment();
        $comment->user_id = $user_id;
        $comment->post_id = $post_id;
        $comment->comment = $content;
        $comment->save();

        return Redirect::back()->with('createComment', 'Successfully  commented');
    }

    public function editCommentView($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        return response()->json($comment);
    }

    public function editComment(CreateCommentRequest $request)
    {
        $user_id = $request->user_id;
        $post_id = $request->post_id;
        $content = $request->input('comment');

        $comment = Comment::find($request->id);
        $comment->user_id = $user_id;
        $comment->post_id = $post_id;
        $comment->comment = $content;
        $comment->save();

        return response()->json($comment);
    }

    public function deleteComment(Request $request)
    {
        $id = $request->id;
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return Redirect::back()->with('deleteComment', 'Comment successfully  deleted');
    }
}
