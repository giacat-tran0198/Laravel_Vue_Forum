@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @forelse($threads as $thread)
                    <div class="card my-3">
                        <div class="card-header">
                            <div class="level">
                                <h3 class="flex">
                                    <a href="{{$thread->path()}}">
                                        @if($thread->hasUpdatesFor(auth()->user()))
                                            <strong>
                                                {{$thread->title}}
                                            </strong>
                                        @else
                                            {{$thread->title}}
                                        @endif
                                    </a>
                                </h3>
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
                    </div>
                @empty
                    <p>Maintenant, il n'y a pas de résultats pertinents.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
