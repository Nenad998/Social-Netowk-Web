<?php

namespace App\Http\Controllers;

use App\Models\Wall_Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WallLikesController extends Controller
{
    public function like(Request $request)
    {
        $user_id = Auth::user()->id;
        $wall_id = $request->wall_id;
        $like = new Wall_Like();
        $like->user_id = $user_id;
        $like->wall_id = $wall_id;

        $isLiked = Wall_Like::where('user_id', '=', $user_id)
                            ->where('wall_id', '=', $wall_id)
                            ->get();

        if($isLiked->isNotEmpty()){
            return Redirect::back()->with('alreadyLikedPost', 'You are already liked this post');
        }
        $like->save();

        return Redirect::back()->with('likePost', 'Successfully  liked post');
    }

    public function unlike(Request $request)
    {
        $user_id = Auth::user()->id;
        $wall_id = $request->wall_id;

        $isUnliked = Wall_Like::where('user_id', '=', $user_id)
                              ->where('wall_id', '=', $wall_id)->get();

        if($isUnliked->isEmpty()){
            return Redirect::back()->with('alreadyUnlikePost', 'You are already unliked this post');
        }

        $like = Wall_Like::where('user_id', '=', $user_id)
                         ->where('wall_id', '=', $wall_id)->delete();

        return Redirect::back()->with('unlikePost', 'Successfully  unliked post');
    }

    public function showUsersLikes($wallId)
    {
        $usersLikes = Wall_Like::with('users')->where('wall_id', '=', $wallId)->get();

        return response()->json($usersLikes);
    }
}
