<?php

namespace App\Http\Controllers;

use App\Http\Requests\WallCommentRequest;
use App\Models\Wall_Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WallCommentController extends Controller
{
    public function createNewComment(WallCommentRequest $request)
    {
        $user_id = Auth::user()->id;
        $wall_id = $request->wall_id;
        $content = $request->input('comment');
        $comment = new Wall_Comment();
        $comment->user_id = $user_id;
        $comment->wall_id = $wall_id;
        $comment->comment = $content;
        $comment->save();

        return Redirect::back()->with('createComment', 'Successfully  commented');
    }

    public function editCommentView($commentId)
    {
        $comment = Wall_Comment::findOrFail($commentId);
        return response()->json($comment);
    }

    public function editComment(WallCommentRequest $request)
    {
        $content = $request->input('comment');

        $comment = Wall_Comment::find($request->id);
        $comment->comment = $content;
        $comment->save();

        return response()->json($comment);
    }

    public function deleteComment(Request $request)
    {
        $id = $request->id;
        $comment = Wall_Comment::findOrFail($id);
        $comment->delete();

        return Redirect::back()->with('deleteComment', 'Comment successfully  deleted');
    }
}
