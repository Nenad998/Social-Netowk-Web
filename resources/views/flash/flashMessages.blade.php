@if(\Session::has('createPost'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('createPost') }}
    </div>
@endif

@if(\Session::has('deletePost'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('deletePost') }}
    </div>
@endif

@if(\Session::has('likePost'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('likePost') }}
    </div>
@endif

@if(\Session::has('alreadyLikedPost'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('alreadyLikedPost') }}
    </div>
@endif

@if(\Session::has('unlikePost'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('unlikePost') }}
    </div>
@endif

@if(\Session::has('alreadyUnlikePost'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('alreadyUnlikePost') }}
    </div>
@endif

@if(\Session::has('createComment'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('createComment') }}
    </div>
@endif

@if(\Session::has('deleteComment'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('deleteComment') }}
    </div>
@endif

@if(\Session::has('likeComment'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('likeComment') }}
    </div>
@endif

@if(\Session::has('alreadyLikedComment'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('alreadyLikedComment') }}
    </div>
@endif

@if(\Session::has('unlikeComment'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('unlikeComment') }}
    </div>
@endif

@if(\Session::has('alreadyUnlikedComment'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('alreadyUnlikedComment') }}
    </div>
@endif

@if(\Session::has('sendFriendRequest'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('sendFriendRequest') }}
    </div>
@endif

@if(\Session::has('alreadySentRequest'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('alreadySentRequest') }}
    </div>
@endif

@if(\Session::has('alreadyFriends'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('alreadyFriends') }}
    </div>
@endif

@if(\Session::has('acceptFriend'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('acceptFriend') }}
    </div>
@endif

@if(\Session::has('rejectFriend'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('rejectFriend') }}
    </div>
@endif

@if(\Session::has('deleteFriend'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('deleteFriend') }}
    </div>
@endif

@if(\Session::has('blockedFriend'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('blockedFriend') }}
    </div>
@endif

@if(\Session::has('unblockedFriend'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('unblockedFriend') }}
    </div>
@endif

@if(\Session::has('editProfile'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('editProfile') }}
    </div>
@endif

@if(\Session::has('createWall'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('createWall') }}
    </div>
@endif

@if(\Session::has('deletePostWall'))
    <div class="alert alert-danger text-center mt-3">
        {{ \Session::get('deletePostWall') }}
    </div>
@endif

@if(\Session::has('markAsRead'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('markAsRead') }}
    </div>
@endif

@if(\Session::has('sendMessage'))
    <div class="alert alert-success text-center mt-3">
        {{ \Session::get('sendMessage') }}
    </div>
@endif

@error('content')
<div class="alert alert-danger text-center">{{ $message }}</div>
@enderror

@error('comment')
<div class="alert alert-danger text-center">{{ $message }}</div>
@enderror

@error('name')
<div class="alert alert-danger text-center">{{ $message }}</div>
@enderror
