<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallCommentController;
use App\Http\Controllers\WallCommentLikesController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WallLikesController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', [WelcomeController::class, 'home']);
Route::post('/registerNenad', [CustomAuthController::class, 'customRegistration']);
Route::get('/customLogin', [CustomAuthController::class, 'showCustomLogin']);
Route::post('/loginNenad', [CustomAuthController::class, 'customLogin']);
//Route::post('/logout', [CustomAuthController::class, 'logout']);

Route::middleware(['guest'])->get('/', [WelcomeController::class, 'home']);
Route::get('/user/profile/edit', [UserController::class, 'showEditUserProfile']);
Route::put('/user/edit', [UserController::class, 'editUser']);
Route::get('/user/profile/{slug}', [UserController::class, 'showUserProfileBySlug']);
Route::get('/singleUser/{id}', [UserController::class, 'showUserBySlug']);


Route::get('/user/members', [MembersController::class, 'showAllMembers']);


Route::post('/user/add_frd', [FriendController::class, 'addFriend']);
Route::put('/user/accept_frd', [FriendController::class, 'acceptFriend']);
Route::delete('/user/reject_frd', [FriendController::class, 'rejectFriend']);
Route::delete('/user/delete_frd', [FriendController::class, 'deleteFriend']);
Route::put('/user/block_frd', [FriendController::class, 'blockFriend']);
Route::put('/user/block_frd_inverse', [FriendController::class, 'blockFriendInverse']);


Route::get('/user/block_frd', [UserController::class, 'showBlockedFriends']);
Route::put('/user/unblock_frd', [FriendController::class, 'unblockFriend']);
Route::put('/user/unblock_frd_inverse', [FriendController::class, 'unblockFriendInverse']);


Route::get('/user/dashboard', [UserController::class, 'showDashboard'])->middleware(['auth'])->name('dashboard');

Route::post('/user/post', [PostController::class, 'createNewPost']);
Route::get('/user/post/{postId}', [PostController::class, 'editPostView']);
Route::put('/user/post', [PostController::class, 'editPost']);
Route::delete('/user/post', [PostController::class, 'deletePost']);

Route::post('/user/comment', [CommentController::class, 'createNewComment']);
Route::get('/user/comment/{commentId}', [CommentController::class, 'editCommentView']);
Route::put('/user/comment', [CommentController::class, 'editComment']);
Route::delete('/user/comment', [CommentController::class, 'deleteComment']);

Route::post('/user/post/like', [LikeController::class, 'like']);
Route::delete('/user/post/unlike', [LikeController::class, 'unlike']);
Route::get('/user/showUsersPostLikes/{postId}', [LikeController::class, 'showUsersLikes']);

Route::post('/user/comment/like', [CommentLikesController::class, 'like']);
Route::delete('/user/comment/unlike', [CommentLikesController::class, 'unlike']);
Route::get('/user/showUsersCommentLikes/{commentId}', [CommentLikesController::class, 'showUsersLikes']);

Route::post('/user/wall', [WallController::class, 'createNewPostOnWall']);
Route::get('/user/wall/{wallId}', [WallController::class, 'editPostOnWallView']);
Route::put('/user/wall', [WallController::class, 'editPostOnWall']);
Route::delete('/user/wall', [WallController::class, 'deletePostOnWall']);

Route::post('/user/wall/like', [WallLikesController::class, 'like']);
Route::delete('/user/wall/unlike', [WallLikesController::class, 'unlike']);
Route::get('/user/showUsersWallLikes/{wallId}', [WallLikesController::class, 'showUsersLikes']);

Route::post('/user/wall/comment', [WallCommentController::class, 'createNewComment']);
Route::get('/user/wall/comment/{commentId}', [WallCommentController::class, 'editCommentView']);
Route::put('/user/wall/comment', [WallCommentController::class, 'editComment']);
Route::delete('/user/wall/comment', [WallCommentController::class, 'deleteComment']);

Route::post('/user/wall/comment/like', [WallCommentLikesController::class, 'like']);
Route::delete('/user/wall/comment/unlike', [WallCommentLikesController::class, 'unlike']);
Route::get('/user/showUsersWallCommentLikes/{commentId}', [WallCommentLikesController::class, 'showUsersLikes']);

Route::get('/user/allFriends/{userId}', [UserController::class, 'allFriends']);

Route::get('/user/sendMessage/{userId}', [MessageController::class, 'sendMessageView']);
Route::post('/user/sendMessage', [MessageController::class, 'sendMessage']);
Route::get('/user/inbox', [MessageController::class, 'inbox']);
Route::get('/user/singleMessage/{userId}', [MessageController::class, 'singleMessage']);

Route::get('/user/markAsRead', function (){

    auth()->user()->unreadNotifications->markAsRead();

    return redirect()->back()->with('markAsRead', 'You read all notifications');
});

//Route::get('/user/comm', [UserController::class, 'showComm']); example...

//Route::get('/user/posts', function (){
//    $posts = Post::all()->where('user_id', '=', Auth::user()->id);
//    //$posts = User::with('posts')->get();
//    @dd($posts['0']);
//});



//Route::get('/user/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
