@extends('layouts.lay')

@section('content')


        @foreach($posts as $post)
                <p><b>post</b></p>
                <p><a href="#">{{ $post->name }}</a> {{ $post->content }}</p>
                <p>{{ $post->created_at->diffForHumans() }} like dislike</p>
                <p><b>Komentari:</b></p>
            @foreach($post->comments as $comment)
                    <p><b>By User:</b>{{ $comment->users_comments->name }}</p>
                <p>{{ $comment->comment }}</p>

            @endforeach
        @endforeach


@endsection
