@extends('layouts.lay')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center">Click On User</h3>
                @foreach($messages as $message)
                    <div class="row">
                        <div class="col mb-1" style="background: #a0aec0">
                            <p><b><a href="/user/singleMessage/{{ $message->users->id }}"> {{ $message->users->name }}</a></b></p>
                            <p>{{ Str::limit($message->content, 40) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col mb-1">
                        <p>{{ $message->users->name }}</p>
                        @include('flash.flashMessages')
                    </div>
                </div>
                <hr>

                @foreach($singleMessages as $singleMessage)
                    <div class="row">
                         <div class="col">
                             <p><b>{{ $singleMessage->name }}</b>:  {{ $singleMessage->content }}</p>
                         </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-8">
                <form method="post" action="/user/sendMessage">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $message->users->id }}">
                    <textarea class="form-control" name="content" rows="4"></textarea>
                    <input class="btn btn-primary btn-sm mt-2" type="submit" value="Send Message">
                </form>
            </div>
        </div>
    </div>

@endsection
