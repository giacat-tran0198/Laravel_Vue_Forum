@forelse($threads as $thread)
    <div class="card my-3">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h3>
                        <a href="{{$thread->path()}}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{$thread->title}}
                                </strong>
                            @else
                                {{$thread->title}}
                            @endif
                        </a>
                    </h3>
                    <h5>Par: <a href="{{route('profiles', $thread->creator->name)}}">{{$thread->creator->name}}</a> </h5>
                </div>
                <strong>
                    <a href="{{$thread->path()}}">
                        {{$thread->replies_count}} {{ Str::plural('reply', $thread->replies_count) }}
                    </a>
                </strong>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body">{{$thread->body}}</div>
        </div>
        <div class="card-footer">
            {{$thread->visits}} vu
        </div>
    </div>
@empty
    <p>Maintenant, il n'y a pas de résultats pertinents.</p>
@endforelse
