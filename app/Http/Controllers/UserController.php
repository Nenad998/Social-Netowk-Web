<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Comment;
use App\Models\Friend;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Wall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function showEditUserProfile()
    {
        $user = Auth::user();
        return view('user.editProfile', ['user'=> $user]);
    }

    public function editUser(UserRequest $request)
    {
        $user = Auth::user();

        $name = $request->name;
        $email = $request->email;
        $gender = $request->gender;

        if ($request->file('image')) {
            $avatar = $request->file('image');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(200, 126)->save( public_path('storage/' . $filename) );
            $user->image = $filename;
        }

        $user->slug = Str::slug($request->name);
        $user->name = $name;
        $user->email = $email;
        $user->gender = $gender;
        $user->save();

        return redirect()->back()->with('editProfile', 'Success edit');
    }

    public function showUserProfileBySlug($slug)
    {
        $user = User::where('slug', $slug)
                    ->where('id', Auth::user()->id)
                    ->firstOrFail();

            // koji user je poslao zahtev - userID1 send request to userID2
            $sendRequest = User::join('friends', 'users.id', '=', 'friends.userID1')
                              ->select('users.name', 'users.id')
                              ->where('friends.confirmed', 0)
                              ->where('friends.userID2', Auth::user()->id)
                              ->get();

            // lista usera koji su prihvatili zahtev - userID2 accept request from userID1
            $acceptedRequestUserID1 = User::join('friends', 'users.id', '=', 'friends.userID2')
                                  ->select('users.name', 'users.id')
                                  ->where('friends.confirmed', 1)
                                  ->where('friends.blocked', 0)
                                  ->where('friends.userID1', Auth::user()->id)
                                  ->get();

            // lista usera koji su prihvatili zahtev  - userID1 accept request from userID2
            $acceptedRequestUserID2 = User::join('friends', 'users.id', '=', 'friends.userID1')
                                  ->select('users.name', 'users.id')
                                   ->where('friends.confirmed', 1)
                                   ->where('friends.blocked', 0)
                                   ->where('friends.userID2', Auth::user()->id)
                                   ->get();

        // show auth users posts
        $posts = Post::with(['likes', 'comments'])->where('user_id', '=', Auth::user()->id)->paginate(10);

        return view('user.userProfile', ['user'=> $user, 'sendRequest'=> $sendRequest, 'acceptedRequestUserID1'=> $acceptedRequestUserID1, 'acceptedRequestUserID2'=> $acceptedRequestUserID2, 'posts'=> $posts]);
    }

    public function showBlockedFriends()
    {
        $blokedFriendsUserID1 = User::join('friends', 'users.id', '=', 'friends.userID2')
                                    ->select('users.name', 'users.id')
                                    ->where('friends.confirmed', 1)
                                    ->where('friends.blocked', 1)
                                    ->where('friends.userID1', Auth::user()->id)
                                    ->get();

        $blokedFriendsUserID2 = User::join('friends', 'users.id', '=', 'friends.userID1')
                                    ->select('users.name', 'users.id')
                                    ->where('friends.confirmed', 1)
                                    ->where('friends.blocked', 1)
                                    ->where('friends.userID2', Auth::user()->id)
                                    ->get();

        return view('user.blocked', ['blokedFriendsUserID1'=> $blokedFriendsUserID1, 'blokedFriendsUserID2'=> $blokedFriendsUserID2]);
    }

    public function showDashboard()
    {
        // ovo vraca sve postove od prijatelja iz kolone userID2
        // show posts and comments belongs to the post of friend from column userID2
        $postsUserID1 = Post::join('users', 'users.id', 'posts.user_id')
                            ->join('friends', 'friends.userID2', 'users.id')
                            ->select('users.name', 'users.id as user_id', 'posts.content', 'posts.created_at', 'posts.id as id')
                            ->where('friends.userID1', Auth::user()->id)
                            ->where('friends.confirmed', 1)
                            ->with('comments')
                            ->with('likes')
                            ->paginate(7);


        // show posts and comments belongs to the post of friend from column userID1
        $postsUserID2 = Post::join('users', 'users.id', 'posts.user_id')
                            ->join('friends', 'friends.userID1', 'users.id')
                            ->select('users.name', 'users.id as user_id', 'posts.content', 'posts.created_at', 'posts.id as id')
                            ->where('friends.userID2', Auth::user()->id)
                            ->where('friends.confirmed', 1)
                            ->with('comments')
                            ->with('likes')
                            ->paginate(7);

        $suggestionUsers = User::select('id', 'name')
                           ->whereNotIN('id', Friend::select('userID1')->get()->toArray())
                           ->whereNotIN('id', Friend::select('userID2')->get()->toArray())
                           ->limit(3)->get();

        return view('dashboard', ['postsUserID1'=> $postsUserID1, 'postsUserID2'=> $postsUserID2, 'suggestionUsers'=> $suggestionUsers]);
    }

    public function showUserBySlug($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $posts = Post::with(['users', 'comments'])->where('user_id', '=', $id)->paginate(5);

        $isFriend = Friend::where('userID1', '=', Auth::user()->id)
                                 ->where('userID2', '=', $user->id)
                                 ->where('confirmed', '=', 1)
                                ->orWhere(function($query) use ($user) {
                                    $query->where('userID2', Auth::user()->id)
                                        ->where('userID1', $user->id)
                                        ->where('confirmed', 1);
                                })->get();

//        if($isFriend->isEmpty()){
//            return 0;
//        } else{
//            return 1;
//        }

        $postOnWall = Wall::with(['users', 'likes', 'comments'])->where('userID2', '=', $id)->paginate(30);


        return view('user.singleUser', ['user'=> $user, 'posts'=> $posts, 'isFriend'=> $isFriend, 'postOnWall'=> $postOnWall]);
    }

    public function allFriends($userId)
    {
        $userID2Friends = User::join('friends', 'friends.userID1', 'users.id')
                         ->select('users.id', 'users.name', 'users.image')
                         ->where('friends.userID2', '=', $userId)
                         ->where('friends.confirmed', '=', 1)
                         ->get();

        $userID1Friends = User::join('friends', 'friends.userID2', 'users.id')
                            ->select('users.id', 'users.name', 'users.image')
                            ->where('friends.userID1', '=', $userId)
                            ->where('friends.confirmed', '=', 1)
                            ->get();

        return view('friends.allFriends', ['userID1Friends'=> $userID1Friends, 'userID2Friends'=> $userID2Friends]);
    }



//    public function showComm()
//    {
//        DB::enableQueryLog();
//        $posts = Post::join('users', 'users.id', 'posts.user_id')
//            ->join('friends', 'friends.userID1', 'users.id')
//            ->with('comments')
//            ->where('friends.userID2', Auth::user()->id)
//            ->where('friends.confirmed', 1)
//            ->select('users.name', 'posts.content', 'posts.created_at', 'posts.id as id')
//            ->get();
//        $query = DB::getQueryLog();
//
//
//
//
//        return view('comm', ['posts'=> $posts]);
//    }

}
