@extends('layouts.lay')

@section('content')

    <div class="container fluid">
        <div class="row">
            <div class="col-md-4 h-75 d-inline-block pb-5 border" style="font-size: 20px">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Friends request
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @foreach($sendRequest as $friend)
                        <li><p>{{ $friend->name }}</p>
                            <form method="post" action="/user/accept_frd">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="userID1" value="{{ $friend['id'] }}">
                                <input class="btn btn-primary" type="submit" value="Confirm">
                            </form>
                            <form method="post" action="/user/reject_frd">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="userID1" value="{{ $friend['id'] }}">
                                <input class="btn btn-danger" type="submit" value="Delete">
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8 pl-5" style="background-color: #eee">
                @if(Auth::user()->image)
                    <h4 class="mt-4"><img src=" {{ asset('storage/'.$user->image) }}" class="rounded-circle" alt="." width="70" height="50">{{ $user->name }} Profile</h4>
                @elseif(Auth::user()->gender == 'male')
                    <h4><img src="{{ asset('images/male.png') }}" class="rounded-circle" alt="." width="70" height="50">{{ $user->name }} Profile</h4>
                @elseif(Auth::user()->gender == 'female')
                    <h4><img src="{{ asset('images/female.png') }}" class="rounded-circle" alt="." width="70" height="50">{{ $user->name }} Profile</h4>
                @endif
            </div>

            @include('flash.flashMessages')

            <div class="col-md-4">
                <a href="/user/profile/edit">Edit profile</a>
                <p><b>All my friends:</b> <a href="/user/block_frd">My blocked friends</a> </p>
                @foreach($acceptedRequestUserID1 as $userID1)
                    <p>{{ $userID1->name }}
                    <form method="post" action="/user/delete_frd">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="userID2" value="{{ $userID1->id }}">
                        <input class="btn btn-danger" type="submit" value="Delete Friend">
                    </form>
                    </p>

                    <form method="post" action="/user/block_frd">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="userID2" value="{{ $userID1->id }}">
                        <input class="btn btn-danger" type="submit" value="Block Friend">
                    </form>
                @endforeach

                @foreach($acceptedRequestUserID2 as $userID2)
                    <p>{{ $userID2->name }}
                    <form method="post" action="/user/delete_frd">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="userID1" value="{{ $userID2->id }}">
                        <input class="btn btn-danger" type="submit" value="Delete Friend">
                    </form>
                    </p>

                    <form method="post" action="/user/block_frd_inverse">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="userID1" value="{{ $userID2->id }}">
                        <input class="btn btn-danger" type="submit" value="Block Friend">
                    </form>
                @endforeach
            </div>

{{--            <div class="col-md-4">--}}

{{--            </div>--}}

            <div class="col-md-8 ">
                <p class="text-center"><b>My posts:</b></p>


                @foreach($posts as $post)
                <div class="post">
                    <p class="mt-4"><b>{{ $post->users->name }} &nbsp</b>{{ $post->content }}</p>
                    <p>{{ $post->created_at->diffForHumans() }}
                        <a href="#" data-bs-toggle="modal" data-bs-target="#ModalLikes" onclick="showUsersPostLikes({{ $post->id }})">{{ $post->likes->count() }} people</a> like this
                    </p>
                    <form style="display: inline;">
                        @csrf
                        <a href="#" data-bs-toggle="modal" data-bs-target="#editPostModal" onclick="editPost({{ $post->id }})"><i class="fas fa-edit fa-lg"></i></a>
                    </form>

                    <form method="post" action="/user/post" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <button type="submit" class="btn btn-secundary"><i class="fas fa-trash fa-lg"></i></button>
                    </form>
                </div>


                    <p class="mt-3"><b>Comments:</b></p>
                    @foreach($post->comments as $comment)
                        @include('comments.comments')
                    @endforeach

                    {{-- add comments   --}}
                    <form method="post" action="/user/comment">
                        @csrf
                        <textarea class="form-control" name="comment" rows="1"></textarea>
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input class="btn btn-primary btn-sm" type="submit" value="Comment">
                    </form>

                @endforeach
                {{ $posts->links() }}

                @include('modal.editComment')
                @include('modal.editPost')
                @include('modal.showLikes')

            </div>
        </div>
    </div>

<script>

    // Edit post
    function editPost(id) {
        //id.preventDefault()
        $.get('/user/post/' + id, function (post) {
            $('#id').val(post.id);
            $('#user_id').val(post.user_id);
            $('#content').val(post.content);
            //$('#editModal').modal("toggle");
            //console.log(post)
        })
    }

    $('#editPostForm').submit(function (e) {
        //e.preventDefault();
        var id = $('#id').val();
        var user_id = $('#user_id').val();
        var content = $('#content').val();
        var _token = $("input[name=_token]").val();
        //console.log(content.content);

        $.ajax({
            url: "/user/post",
            type: 'PUT',
            data: {
                id: id,
                user_id: user_id,
                content: content,
                _token: _token
            },
            success: function (response) {
                window.location = "{{URL::to('/user/profile/'. Auth::user()->slug)}}";
                $('#editModal').modal("hide");
            },
            error: function (response) {
                console.log(response)
            }
        })
    })
    // end of edit post

    //show users likes for post
    function showUsersPostLikes(id){
        $("#likes").empty()
        $.get('/user/showUsersPostLikes/' + id, function (post) {
            //console.log(post)
            //console.log(post[0].users.name)
            for(var i=0;i<post.length;i++){
                //console.log(post[i].users.image)
                $("#likes").append("<img width='70' height='50' src='http://127.0.0.1:8000/storage/"+post[i].users.image+"' <p><a href="+'/singleUser/'+post[i].users.id+">"+post[i].users.name+"</a></p>")
            }
        })
    }

    // Edit comment
    function editComment(id){
        $.get('/user/comment/' + id, function (comment) {
            $('#id').val(comment.id);
            $('#user_id').val(comment.user_id);
            $('#post_id').val(comment.post_id);
            $('#comment').val(comment.comment);
            //$('#editModal').modal("toggle");
            console.log(comment)
        })
    }

    $('#editForm').submit(function (e) {
        e.preventDefault();
        var id = $('#id').val();
        var user_id = $('#user_id').val();
        var post_id = $('#post_id').val();
        var comment = $('#comment').val();
        var _token = $("input[name=_token]").val();
        //console.log(user_id)

        $.ajax({
            url: "/user/comment",
            type: 'PUT',
            data: {
                id: id,
                user_id: user_id,
                post_id: post_id,
                comment: comment,
                _token: _token
            },
            success: function (response) {

                window.location = "{{URL::to('/user/profile/'. Auth::user()->slug)}}";
                $('#editModal').modal("hide");
                //console.log(response)
            },
            error: function (response) {
                console.log(response)
            }
        })
    })
    // End edit comment


    // // show users likes for comment
    function showUsersCommentLikes(id){
        $("#likes").empty()
        $.get('/user/showUsersCommentLikes/' + id, function (comment) {
            //console.log(comment)
            for(var i=0;i<comment.length;i++){
                $("#likes").append("<img width='70' height='50' src='http://127.0.0.1:8000/storage/"+comment[i].users.image+"'<p><a href="+'/singleUser/'+comment[i].users.id+">"+comment[i].users.name+"</a></p>")
            }
        })
    }
</script>


@endsection
