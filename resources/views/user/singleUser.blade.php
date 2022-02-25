@extends('layouts.lay')

@section('content')

    @include('flash.flashMessages')

    <p><b>User: </b>{{ $user->name }}</p>
    @if($isFriend->isEmpty())
        <form method="post" action="/user/add_frd">
            @csrf
            <input type="hidden" name="userID2" value="{{ $user->id }}">
            <input class="btn btn-primary" type="submit" value="Add">
        </form>
    @endif

    {{-- add post on wall  --}}
    @if(!$isFriend->isEmpty())
        <a class="btn btn-primary btn-sm" href="/user/sendMessage/{{ $user->id }}" role="button">Send Message</a>

        <div class="col-md-4">
        <form method="post" action="/user/wall/">
            @csrf
            <textarea class="form-control" name="content" rows="4"></textarea>
            <input type="hidden" name="userID2" value="{{ $user->id }}">
            <input class="btn btn-primary btn-sm" type="submit" value="Add Post">
        </form>
        </div>
    @endif

   <p><b>All posts:</b> <a href="/user/allFriends/{{ $user->id }}">All friends</a> </p>

    {{-- posts on wall  --}}
    @foreach($postOnWall as $tempPostOnWall)
        <div>
            <p><a href="/singleUser/{{ $tempPostOnWall->users->id }}">{{ $tempPostOnWall->users->name }}</a> > {{ $user->name }}</p>
              @if($tempPostOnWall->userID1 == Auth::user()->id)
                <form style="display: inline;">
                    @csrf
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editPostWallModal" onclick="editPostWall({{ $tempPostOnWall->id }})"><i class="fas fa-edit fa-lg"></i></a>
                </form>

                <form method="post" action="/user/wall" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $tempPostOnWall->id }}">
                    <button type="submit" class="btn btn-secundary"><i class="fas fa-trash fa-lg"></i></button>
                </form>
              @endif
        </div>
        <p class="mt-2"><b>{{ $tempPostOnWall->content }}</b></p>
        <p>{{ $tempPostOnWall->created_at->diffForHumans() }}
            <a href="#" data-bs-toggle="modal" data-bs-target="#ModalLikes" onclick="showUsersPostWallLikes({{ $tempPostOnWall->id }})"> {{ $tempPostOnWall->likes->count() }} people</a> like this
            <form method="post" action="/user/wall/like">
                @csrf
                <input type="hidden" name="wall_id" value="{{ $tempPostOnWall->id }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></button>
            </form>
            <form method="post" action="/user/wall/unlike">
                @csrf
                @method('DELETE')
                <input type="hidden" name="wall_id" value="{{ $tempPostOnWall->id }}">
                <button type="submit" class="btn btn-danger"><i class="fas fa-thumbs-down"></i></button>
            </form>
        </p>


        <div class="col-md-4">
            <p><b>Comments:</b></p>
            @foreach($tempPostOnWall->comments as $comment )
                @include('comments.wallComments')
            @endforeach

            {{-- add comments   --}}
            @if(!$isFriend->isEmpty())
                <form method="post" action="/user/wall/comment">
                    @csrf
                    <textarea class="form-control" name="comment" rows="1"></textarea>
                    <input type="hidden" name="wall_id" value="{{ $tempPostOnWall->id }}">
                    <input class="btn btn-primary btn-sm" type="submit" value="Comment">
                </form>
            @endif
        </div>


        @include('modal.editPostWall')
        @include('modal.editWallComment')
        @include('modal.showWallCommentLikes')
    @endforeach

    {{ $postOnWall->links() }}


    {{-- normal posts of user  --}}

    @foreach($posts as $post)
        <div>
            <p><b>{{ $post->users->name }} &nbsp;</b> &nbsp;{{ $post->content }}</p>
            <p>{{ $post->created_at->diffForHumans() }}
                <a href="#" data-bs-toggle="modal" data-bs-target="#ModalLikes" onclick="showUsersPostLikes({{ $post->id }})">{{ $post->likes->count() }} people</a> like this
            <form method="post" action="/user/post/like">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button type="submit" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></button>
            </form>
            <form method="post" action="/user/post/unlike">
                @csrf
                @method('DELETE')
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button type="submit" class="btn btn-danger"><i class="fas fa-thumbs-down"></i></button>
            </form>
            </p>
        </div>

        <div class="col-md-4">
            <p><b>Comments:</b></p>
            @foreach($post->comments as $comment )
                @include('comments.comments')
            @endforeach

            {{-- add comments   --}}
            @if(!$isFriend->isEmpty())
                <form method="post" action="/user/comment">
                   @csrf
                    <textarea class="form-control" name="comment" rows="1"></textarea>
                   <input type="hidden" name="post_id" value="{{ $post->id }}">
                   <input class="btn btn-primary btn-sm" type="submit" value="Comment">
               </form>
            @endif
                </div>

                @include('modal.editComment')
                @include('modal.showLikes')

    @endforeach

    {{ $posts->links() }}
            <script>

                // Edit comment
                function editComment(id){
                    $.get('/user/comment/' + id, function (comment) {
                        $('#id').val(comment.id);
                        $('#user_id').val(comment.user_id);
                        $('#post_id').val(comment.post_id);
                        $('#comment').val(comment.comment);
                        //$('#editModal').modal("toggle");
                        //console.log(comment)
                    })
                }

                $('#editForm').submit(function (e) {
                    //e.preventDefault();
                    var id = $('#id').val();
                    var user_id = $('#user_id').val();
                    var post_id = $('#post_id').val();
                    var comment = $('#comment').val();
                    var _token = $("input[name=_token]").val();
                    //console.log(e)

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
                            //window.history.back();
                            window.location = "{{URL::to('/singleUser/' . $user->id )}}";
                            $('#editModal').modal("hide");
                            //console.log(response)
                        },
                        error: function (response) {
                            console.log('wrong: ' + response)
                        }
                    })
                })
                // End edit comment

                // show users likes for post
                function showUsersPostLikes(id){
                    $("#likes").empty()
                    $.get('/user/showUsersPostLikes/' + id, function (post) {
                        //console.log(post)
                        //console.log(post[0].users.name)
                        for(var i=0;i<post.length;i++){
                            $("#likes").append("<img width='70' height='50' src='http://127.0.0.1:8000/storage/"+post[i].users.image+"'<p><a href="+'/singleUser/'+post[i].users.id+">"+post[i].users.name+"</a></p>")
                        }
                    })
                }

                // show users likes for comment
                function showUsersCommentLikes(id){
                    $("#likes").empty()
                    $.get('/user/showUsersCommentLikes/' + id, function (comment) {
                        //console.log(comment)
                        for(var i=0;i<comment.length;i++){
                            $("#likes").append("<img width='70' height='50' src='http://127.0.0.1:8000/storage/"+comment[i].users.image+"'<p><a href="+'/singleUser/'+comment[i].users.id+">"+comment[i].users.name+"</a></p>")
                        }
                    })
                }

                // Edit post on wall
                function editPostWall(id) {
                    $.get('/user/wall/' + id, function (wall) {
                        $('#id').val(wall.id);
                        $('#content').val(wall.content);
                        //console.log(wall.content)
                    })
                }

                $('#editPostWallForm').submit(function (e) {
                    var id = $('#id').val();
                    var content = $('#content').val();
                    var _token = $("input[name=_token]").val();
                    //console.log(user_id)

                    $.ajax({
                        url: "/user/wall",
                        type: 'PUT',
                        data: {
                            id: id,
                            content: content,
                            _token: _token
                        },
                        success: function (response) {

                            window.location = "{{URL::to('/singleUser/' . $user->id )}}";
                            $('#editModal').modal("hide");
                            //console.log(response)
                        },
                        error: function (response) {
                            console.log('greska ' + response)
                        }
                    })
                })
                // end edit post on wall

                // show users likes for post on the wall
                function showUsersPostWallLikes(id){
                    $("#likes").empty()
                    $.get('/user/showUsersWallLikes/' + id, function (wall) {
                        //console.log(wall)
                        //console.log(post[0].users.name)
                        for(var i=0;i<wall.length;i++){
                            $("#likes").append("<img width='70' height='50' src='http://127.0.0.1:8000/storage/"+wall[i].users.image+"'<p><a href="+'/singleUser/'+wall[i].users.id+">"+wall[i].users.name+"</a></p>")
                        }
                    })
                }

                // Edit comment on wall
                function editWallComment(id){
                    $.get('/user/wall/comment/' + id, function (comment) {
                        $('#id').val(comment.id);
                        $('#comment').val(comment.comment);
                        //console.log(comment.id);
                    })
                }

                $('#editWallCommentForm').submit(function (e) {
                    e.preventDefault();
                    var id = $('#id').val();
                    var comment = $('#comment').val();
                    var _token = $("input[name=_token]").val();
                    //console.log(e)

                    $.ajax({
                        url: "/user/wall/comment",
                        type: 'PUT',
                        data: {
                            id: id,
                            comment: comment,
                            _token: _token
                        },
                        success: function (response) {
                            //window.history.back();
                            window.location = "{{URL::to('/singleUser/' . $user->id )}}";
                            $('#editModal').modal("hide");
                            //console.log(response)
                        },
                        error: function (response) {
                            console.log('wrong: ' + response)
                        }
                    })
                })
                // End edit comment

                // show users likes for comment on the wall
                function showUsersWallCommentLikes(id){
                    $("#likes").empty()
                    $.get('/user/showUsersWallCommentLikes/' + id, function (comment) {
                        //console.log(comment)
                        for(var i=0;i<comment.length;i++){
                            $("#likes").append("<img width='70' height='50' src='http://127.0.0.1:8000/storage/"+comment[i].users.image+"'<p><a href="+'/singleUser/'+comment[i].users.id+">"+comment[i].users.name+"</a></p>")
                        }
                    })
                }

            </script>
        @endsection
