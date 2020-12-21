<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card my-3">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a href="{{route('profiles', $reply->owner)}}">
                        {{$reply->owner->name}}
                    </a> a publié {{$reply->created_at->diffForHumans()}} ...
                </h6>
                <div>
                    <form method="post" action="{{route('replies.favorites', ['reply' => $reply->id])}}">
                        @csrf
                        <button type="submit" class="btn btn-info" {{$reply->isFavorited() ? 'disabled' : ''}}>
                            J'aimme {{$reply->favorites_count}} <i
                                class="{{$reply->isFavorited() ? 'fas' : 'far'}} fa-heart"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="update">Actualiser</button>
                <button class="btn btn-link btn-sm" @click="editing = false">Annuler</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-info btn-sm mr-1" @click="editing = true">Modifier</button>
                <button class="btn btn-danger btn-sm mr-1" @click="destroy">Supprimer</button>
            </div>
        @endcan
    </div>
</reply>
