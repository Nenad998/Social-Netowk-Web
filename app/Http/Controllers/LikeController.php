<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\LikePostNotifications;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LikeController extends Controller
{
    public function like(Request  $request)
    {
        $ownerPost = $request->ownerPostId;

        $user_id = Auth::user()->id;
        $post_id = $request->post_id;
        $like = new Like();
        $like->user_id = $user_id;
        $like->post_id = $post_id;

        $isLiked = Like::where('user_id', '=', $user_id)
                         ->where('post_id', '=', $post_id)
                         ->get();

        if($isLiked->isNotEmpty()){
            return Redirect::back()->with('alreadyLikedPost', 'You are already liked this post');
        }
        Notification::send(User::find($ownerPost), new LikePostNotifications(Auth::user()->name));
        $like->save();

        return Redirect::back()->with('likePost', 'Successfully  liked post');
    }

    public function unlike(Request $request)
    {
        $user_id = Auth::user()->id;
        $post_id = $request->post_id;

        $isUnliked = Like::where('user_id', '=', $user_id)
                         ->where('post_id', '=', $post_id)->get();

        if($isUnliked->isEmpty()){
            return Redirect::back()->with('alreadyUnlikePost', 'You are already unliked this post');
        }

        $like = Like::where('user_id', '=', $user_id)
                    ->where('post_id', '=', $post_id)->delete();

        return Redirect::back()->with('unlikePost', 'Successfully  unliked post');
    }

    public function showUsersLikes($postId)
    {
        $usersLikes = Like::with('users')->where('post_id', '=', $postId)->get();

        return response()->json($usersLikes);
    }
}
