@extends('layouts.lay')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center">Click On User</h3>


{{--                @foreach($messages1 as $message)--}}
{{--                    <div class="row">--}}
{{--                        <div class="col mb-1" style="background: #a0aec0">--}}
{{--                            <p><b><a href="/user/singleMessage/{{ $message->id }}">{{ $message->name }}</a></b></p>--}}
{{--                            <p>{{ Str::limit($message->content, 40) }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}


                @foreach($messages2 as $message)
                    <div class="row">
                        <div class="col mb-1" style="background: #a0aec0">
                            <p><b><a href="/user/singleMessage/{{ $message->id }}">{{ $message->name }}</a></b></p>
                            <p>{{ Str::limit($message->content, 40) }}</p>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="col-md-8">
                <h3 class="text-center">Messages</h3>
            </div>
        </div>
    </div>

@endsection
