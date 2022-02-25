<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\Notifications\LikePostNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FriendController extends Controller
{
    public function addFriend(Request $request)
    {
        $user1 = Auth::user()->id;
        $user2 = $request->userID2;

        $friend = new Friend();
        $friend->userID1 = $user1;
        $friend->userID2 = $user2;


        $isSentRequest = Friend::where('userID1', '=', $user1)
                                ->where('userID2', '=', $user2)
                                ->orWhere(function($query) use ($user1, $user2) {
                                    $query->where('userID2', $user1)
                                        ->where('userID1', $user2)
                                        ->where('confirmed', 1);
                                })->get();

        $isAlreadyFriend = Friend::where('userID1', '=', $user2)
                                  ->where('userID2', '=', $user1)
                                  ->where('confirmed', '=', 1)
                                ->orWhere(function($query) use ($user1, $user2) {
                                    $query->where('userID2', $user2)
                                        ->where('userID1', $user1)
                                        ->where('confirmed', 1);
                                })->get();

        if($isAlreadyFriend->isNotEmpty()){
            return Redirect::back()->with('alreadyFriends', 'You are already friends');
        } elseif($isSentRequest->isNotEmpty()){
            return Redirect::back()->with('alreadySentRequest', 'Request already sent');
        } else{
            $friend->save();
           //Notification::send($friend->userID2, new LikePostNotifications($request->userID1));
            return Redirect::back()->with('sendFriendRequest', 'Friend request successfully sent');
        }

    }

    public function acceptFriend(Request $request)
    {
        $userID1 = $request->userID1;
        $userID2 = Auth::user()->id;

        $friend = Friend::where('userID1', '=', $userID1)->first();

        $friend->userID1 = $userID1;
        $friend->userID2 = $userID2;
        $friend->confirmed = 1;
        $friend->save();

        return Redirect::back()->with('acceptFriend', 'Confirmed friend request');
    }

    public function rejectFriend(Request $request)
    {
        $userID1 = $request->userID1;
        $userID2 = Auth::user()->id;

        $friend = Friend::where('userID1', '=', $userID1)->first();
        $friend->delete();

        return Redirect::back()->with('rejectFriend', 'Deleted friend request');
    }

    public function deleteFriend(Request $request)
    {
        $userID1 = Auth::user()->id;
        $userID2 = $request->userID2;

        // this refer to userID1 from input field, in inverse way of deleting (user from column userID2 can delete user from column userID1)
        $user_id1 = $request->userID1;

        $friend = Friend::where('userID1', '=', $userID1)
                        ->where('userID2', '=', $userID2)
                        ->where('confirmed', '=', 1)
                        ->orWhere('userID1', '=', $user_id1)
                        ->where('userID2', '=', $userID1)
                        ->first();

        $friend->delete();

        return Redirect::back()->with('deleteFriend', 'Successfully deleted friend');
    }

    public function blockFriend(Request $request)
    {
        $userID1 = Auth::user()->id;
        $userID2 = $request->userID2;

        $user_id1 = $request->userID1;

        $friend = Friend::where('userID1', '=', $userID1)
                        ->where('userID2', '=', $userID2)
                        ->where('confirmed', '=', 1)
                        ->first();

        $friend->userID1 = $userID1;
        $friend->userID2 = $userID2;
        $friend->blocked = 1;
        $friend->save();

        return Redirect::back()->with('blockedFriend', 'Successfully blocked friend');

    }

    // inverse way of blocking (user from column userID2 can block user from column userID1)
    public function blockFriendInverse(Request $request)
    {
        $userID1 = $request->userID1;
        $userID2 = Auth::user()->id;

        $friend = Friend::where('userID1', '=', $userID1)
                        ->where('userID2', '=', $userID2)
                        ->where('confirmed', '=', 1)
                        ->first();

        $friend->userID1 = $userID1;
        $friend->userID2 = $userID2;
        $friend->blocked = 1;
        $friend->save();

        return Redirect::back()->with('blockedFriend', 'Successfully blocked friend');
    }

    public function unblockFriend(Request $request)
    {
        $userID1 = Auth::user()->id;
        $userID2 = $request->userID2;

        $friend = Friend::where('userID1', '=', $userID1)
                        ->where('userID2', '=', $userID2)
                        ->where('confirmed', '=', 1)
                        ->where('blocked', '=', 1)
                        ->first();

        $friend->userID1 = $userID1;
        $friend->userID2 = $userID2;
        $friend->blocked = 0;
        $friend->save();

        return Redirect::back()->with('unblockedFriend', 'Successfully unblocked friend');
    }

    public function unblockFriendInverse(Request $request)
    {
        $userID1 = $request->userID1;
        $userID2 = Auth::user()->id;

        $friend = Friend::where('userID1', '=', $userID1)
                        ->where('userID2', '=', $userID2)
                        ->where('confirmed', '=', 1)
                        ->where('blocked', '=', 1)
                        ->first();

        $friend->userID1 = $userID1;
        $friend->userID2 = $userID2;
        $friend->blocked = 0;
        $friend->save();

        return Redirect::back()->with('unblockedFriend', 'Successfully unblocked friend');
    }
}
