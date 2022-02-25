<?php

namespace App\Http\Controllers;

use App\Models\Wall_Comment_Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WallCommentLikesController extends Controller
{
    public function like(Request $request)
    {
        $user_id = Auth::user()->id;
        $wall_comment_id = $request->wall_comment_id;
        $wall_comment_like = new Wall_Comment_Like();
        $wall_comment_like->user_id = $user_id;
        $wall_comment_like->wall_comment_id = $wall_comment_id;

        $isLiked = Wall_Comment_Like::where('user_id', '=', $user_id)
            ->where('wall_comment_id', '=', $wall_comment_id)
            ->get();

        if($isLiked->isNotEmpty()){
            return Redirect::back()->with('alreadyLikedComment', 'You are already liked this comment');
        }
        $wall_comment_like->save();

        return Redirect::back()->with('likeComment', 'Successfully  liked comment');
    }

    public function unlike(Request $request)
    {
        $user_id = Auth::user()->id;
        $wall_comment_id = $request->wall_comment_id;

        $isUnliked = Wall_Comment_Like::where('user_id', '=', $user_id)
            ->where('wall_comment_id', '=', $wall_comment_id)->get();

        if($isUnliked->isEmpty()){
            return Redirect::back()->with('alreadyUnlikedComment', 'You are already unliked this comment');
        }

        $comment_like = Wall_Comment_Like::where('user_id', '=', $user_id)
            ->where('wall_comment_id', '=', $wall_comment_id)->delete();

        return Redirect::back()->with('unlikeComment', 'Successfully  unliked comment');
    }

    public function showUsersLikes($commentId)
    {
        $usersLikes = Wall_Comment_Like::with('users')->where('wall_comment_id', '=', $commentId)->get();

        return response()->json($usersLikes);
    }
}
