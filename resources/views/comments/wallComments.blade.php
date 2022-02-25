<p><a href="/singleUser/{{ $comment->users_comments->id }}">{{ $comment->users_comments->name }}</a>  {{ $comment->comment }}
    @if($comment->user_id == Auth::user()->id)
        <a href="#" data-bs-toggle="modal" data-bs-target="#ModalLikes" onclick="showUsersCommentLikes({{ $comment->id }})"><i class="fas fa-edit fa-lg"></i></a>

<form method="post" action="/user/wall/comment">
    @csrf
    @method('DELETE')
    <input type="hidden" name="id" value="{{ $comment->id }}">
    <button type="submit" class="btn btn-secundary"><i class="fas fa-trash fa-lg"></i></button>
</form>
@endif
<p>{{ optional($comment->created_at)->diffForHumans() }}
    <a href="#" data-bs-toggle="modal" data-bs-target="#WallModalLikes" onclick="showUsersWallCommentLikes({{ $comment->id }})">{{ optional($comment->comment_likes)->count() }} people</a> like this
</p>
<form method="post" action="/user/wall/comment/like">
    @csrf
    <input type="hidden" name="wall_comment_id" value="{{ $comment->id }}">
    <button type="submit" class="btn btn-primary"><i class="fas fa-thumbs-up"></i></button>
</form>
<form method="post" action="/user/wall/comment/unlike">
    @csrf
    @method('DELETE')
    <input type="hidden" name="wall_comment_id" value="{{ $comment->id }}">
    <button type="submit" class="btn btn-danger"><i class="fas fa-thumbs-down"></i></button>
</form>
