@extends('layouts.lay')

@section('content')

    <p><b>All friends:</b></p>
    @foreach($userID2Friends as $userFriend)
        <p>{{ $userFriend->name }}</p>
    @endforeach

    @foreach($userID1Friends as $userFriend)
        <p>{{ $userFriend->name }}</p>
    @endforeach

@endsection
