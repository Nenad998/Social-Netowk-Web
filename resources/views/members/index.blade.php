@extends('layouts.lay')

@section('content')

    <div class="container fluid">
        <div class="row">
            <div class="col-md-4 h-75 d-inline-block pb-5 border" style="font-size: 20px">
                    <p class="mt-3"><a href="/user/profile/{{ Auth::user()->name }}"><img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle" alt="." width="70" height="50"></a>{{ Auth::user()->name }}</p>
                <a href="/user/profile">Edit profile</a> <br>
                <a href="/user/members">Members</a>

                @include('flash.flashMessages')
            </div>

            <div class="col-md-8 pl-5 " style="background-color: #eee">
               <div><a href="#" style="color: #1a202c"> <h4 class="mt-4">Members</h4></a></div>
                <div class="float-end mb-3"><p>Visit your <a href="#">Friends</a> </p></div>

                <div class="mt-5 col-md-8">
                    @foreach($users as $user)
                        <div>
                            <p class="mt-3"><a href="/singleUser/{{ $user->id }}">
                            <img src="{{ asset('storage/'.$user->image) }}" class="rounded-circle" alt="." width="70" height="50"></a>
                            <a href="/singleUser/{{ $user->id }}"> {{ $user->name }}</a>

                            <form method="post" action="/user/add_frd">
                                @csrf
                                <input type="hidden" name="userID2" value="{{ $user->id }}">
                                <input class="btn btn-primary" type="submit" value="Add">
                            </form>
                        </p></div>
                    @endforeach
                        {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection


