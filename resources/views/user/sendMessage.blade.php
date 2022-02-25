@extends('layouts.lay')

@section('content')

    @include('flash.flashMessages')

    <b>User: </b>{{ $user->name }}
    <div class="col-md-4">
        <form method="post" action="/user/sendMessage">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <textarea class="form-control" name="content" rows="4"></textarea>
            <input class="btn btn-primary btn-sm mt-2" type="submit" value="Send Message">
        </form>
    </div>


@endsection
