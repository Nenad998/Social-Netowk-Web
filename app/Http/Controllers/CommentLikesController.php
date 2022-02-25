<?php

namespace App\Http\Controllers;

use App\Models\Comment_Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommentLikesController extends Controller
{
    public function like(Request $request)
    {
        $user_id = Auth::user()->id;
        $comment_id = $request->comment_id;
        $comment_like = new Comment_Like();
        $comment_like->user_id = $user_id;
        $comment_like->comment_id = $comment_id;

        $isLiked = Comment_Like::where('user_id', '=', $user_id)
                               ->where('comment_id', '=', $comment_id)
                               ->get();

        if($isLiked->isNotEmpty()){
            return Redirect::back()->with('alreadyLikedComment', 'You are already liked this comment');
        }
        $comment_like->save();

        return Redirect::back()->with('likeComment', 'Successfully  liked comment');
    }

    public function unlike(Request $request)
    {
        $user_id = Auth::user()->id;
        $comment_id = $request->comment_id;

        $isUnliked = Comment_Like::where('user_id', '=', $user_id)
                                 ->where('comment_id', '=', $comment_id)->get();

        if($isUnliked->isEmpty()){
            return Redirect::back()->with('alreadyUnlikedComment', 'You are already unliked this comment');
        }

        $comment_like = Comment_Like::where('user_id', '=', $user_id)
                                    ->where('comment_id', '=', $comment_id)->delete();

        return Redirect::back()->with('unlikeComment', 'Successfully  unliked comment');
    }

    public function showUsersLikes($commentId)
    {
        $usersLikes = Comment_Like::with('users')->where('comment_id', '=', $commentId)->get();

        return response()->json($usersLikes);
    }

}
