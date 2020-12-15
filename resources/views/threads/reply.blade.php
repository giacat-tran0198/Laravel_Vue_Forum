<div class="card my-3">
    <div class="card-header">
        <div class="level">
            <h6 class="flex">
                <a href="{{route('threads.index', ['by' => $reply->owner->name])}}">
                    {{$reply->owner->name}}
                </a> a publié {{$reply->created_at->diffForHumans()}} ...
            </h6>
            <div>
                <form method="post" action="{{route('replies.favorites', ['reply' => $reply->id])}}">
                    @csrf
                    <button type="submit" class="btn btn-info" {{$reply->isFavorited() ? 'disabled' : ''}}>
                        J'aimme {{$reply->favorites->count()}} <i class="{{$reply->isFavorited() ? 'fas' : 'far'}} fa-heart"></i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>
