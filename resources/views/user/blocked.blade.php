@extends('layouts.lay')

@section('content')

    @include('flash.flashMessages')

    <a href="/user/profile/{{ Auth::user()->slug }}">Back to profile</a>

@foreach($blokedFriendsUserID1 as $friends)
    <p>{{ $friends->name }}
    <form method="post" action="/user/unblock_frd">
        @csrf
        @method('PUT')
        <input type="hidden" name="userID2" value="{{ $friends->id }}">
        <input class="btn btn-danger" type="submit" value="Unblock Friend">
    </form>
    </p>
@endforeach

@foreach($blokedFriendsUserID2 as $friends)
    <p>{{ $friends->name }}
    <form method="post" action="/user/unblock_frd_inverse">
        @csrf
        @method('PUT')
        <input type="hidden" name="userID1" value="{{ $friends->id }}">
        <input class="btn btn-danger" type="submit" value="Unblock Friend">
    </form>
    </p>
@endforeach

@endsection
