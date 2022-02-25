@extends('layouts.lay')

@section('content')

    <div class="container fluid">
        <div class="row">
            <div class="col-md-4 h-75 d-inline-block pb-5 border" style="font-size: 20px">
                @if(Auth::user()->image)
                    <p class="mt-3"><a href="/user/profile/{{ Auth::user()->slug }}"><img src="/storage/{{ Auth::user()->image }} " class="rounded-circle" alt="." width="70" height="50"></a>{{ Auth::user()->name }} Profile</p>
                    @elseif(Auth::user()->gender == 'male')
                    <p><a href="/user/profile/{{ Auth::user()->slug }}"><img src="{{ asset('images/male.png') }}" class="rounded-circle" alt="." width="70" height="50"></a>{{ Auth::user()->name }} Profile</p>
                @elseif(Auth::user()->gender == 'female')
                    <p><a href="/user/profile/{{ Auth::user()->slug }}"><img src="{{ asset('images/female.png') }}" class="rounded-circle" alt="." width="70" height="50"></a>{{ Auth::user()->name }} Profile</p>
                    @endif
            </div>

            <div class="col-md-8 pl-5" style="background-color: #eee">
                @if(Auth::user()->image)
                <h4 class="mt-4"><img src=" {{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle" alt="." width="70" height="50">{{ Auth::user()->name }}</h4>
                    @elseif(Auth::user()->gender == 'male')
                    <h4><img src="{{ asset('images/male.png') }}" class="rounded-circle" alt="." width="70" height="50">{{ Auth::user()->name }} </h4>
                @elseif(Auth::user()->gender == 'female')
                    <h4><img src="{{ asset('images/female.png') }}" class="rounded-circle" alt="." width="70" height="50">{{ Auth::user()->name }} </h4>
                    @endif

            </div>
            <div class="col-md-4">
                <p><a href="/user/members">Members</a> </p>
                <p><a href="/user/inbox">Inbox</a> </p>
            </div>
            <div class="col-md-8">

                @include('flash.flashMessages')

                <div class="col-md-6">
                <form method="post" action="/user/post">
                    @csrf
                    <label class="form-label">Create post</label>
                    <textarea class="form-control" name="content" cols="3" rows="3"></textarea>
                    <input class="btn btn-primary" type="submit" value="Add">
                </form>
                </form>



                    <p><b>Suggestions:</b></p>
                    @foreach($suggestionUsers as $suggestionUser)
                        <p><a href="/singleUser/{{ $suggestionUser->id }}">{{ $suggestionUser->name }}</a>
                        <form method="post" action="/user/add_frd">
                            @csrf
                            <input type="hidden" name="userID2" value="{{ $suggestionUser->id }}">
                            <input class="btn btn-primary" type="submit" value="Add">
                        </form>
                        </p>
                    @endforeach

                    {{-- logic for userID1   --}}

                @foreach($postsUserID1 as $userID1)
                    <p><a href="/singleUser/{{ $userID1->user_id }}">{{ $userID1->name }}</a>&nbsp; {{ $userID1->content }}</p>
                    <p>{{ $userID1->created_at->diffForHumans() }}
                        <a href="#" data-bs-toggle="modal" data-bs-target="#ModalLikes" onclick="showUsersPostLikes({{ $userID1->id }})">{{ $userID1->likes->count() }} people</a> like this
                        <form method="post" action="/user/post/like">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $userID1->id }}">
                            <input type="hidden" name="ownerPostId" value="{{ $userID1->user_id }}">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></button>
                        </form>
                        <form method="post" action="/user/post/unlike">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="post_id" value="{{ $userID1->id }}">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-thumbs-down"></i></button>
                        </form>
                    </p>

                        <p><b>Comments:</b></p>
                        @foreach($userID1->comments as $comment )
                            @include('comments.comments')
                        @endforeach

                                {{-- add comments   --}}
                        <form method="post" action="/user/comment">
                            @csrf
                            <textarea class="form-control" name="comment" rows="1"></textarea>
                            <input type="hidden" name="post_id" value="{{ $userID1->id }}">
                            <input class="btn btn-primary btn-sm" type="submit" value="Comment">
                        </form>
                @endforeach
                    {{ $postsUserID1->links() }}
                                {{-- end logic for userID1   --}}



                       {{--  logic for userID2   --}}

                    @foreach($postsUserID2 as $userID2)
                        <p><a href="/singleUser/{{ $userID2->user_id }}">{{ $userID2->name }}</a>&nbsp; {{ $userID2->content }} </p>
                        <p>{{ $userID2->created_at->diffForHumans() }}
                         <a href="#" data-bs-toggle="modal" data-bs-target="#ModalLikes" onclick="showUsersPostLikes({{ $userID2->id }})">{{ $userID2->likes->count() }} people</a> like this
                             <form method="post" action="/user/post/like">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $userID2->id }}">
                            <input type="hidden" name="ownerPostId" value="{{ $userID2->user_id }}">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></button>
                             </form>
                             <form method="post" action="/user/post/unlike">
                                @csrf
                                @method('DELETE')
                                   <input type="hidden" name="post_id" value="{{ $userID2->id }}">
                                   <button type="submit" class="btn btn-danger"><i class="fas fa-thumbs-down"></i></button>
                              </form>
                        </p>


                        <p><b>Comments:</b></p>
                        @foreach($userID2->comments as $comment )
                            @include('comments.comments')
                        @endforeach

                            add comments
                        <form method="post" action="/user/comment">
                            @csrf
                            <textarea class="form-control" name="comment" rows="1"></textarea>
                            <input type="hidden" name="post_id" value="{{ $userID2->id }}">
                            <input class="btn btn-primary btn-sm" type="submit" value="Comment">
                        </form>
                    @endforeach
                    {{ $postsUserID2->links() }}

                                   {{-- end  logic for userID2   --}}

                     @include('modal.editComment')
                     @include('modal.showLikes')

            </div>
        </div>
    </div>


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

                    window.location = "{{URL::to('/user/dashboard')}}";
                    $('#editModal').modal("hide");
                    //console.log(response)
                },
                error: function (response) {
                    console.log(response)
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

    </script>

@endsection
