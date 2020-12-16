@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('profiles', $thread->creator)}}">{{$thread->creator->name}}</a>
                        a publié:
                        {{$thread->title}}
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{$replies->links()}}
                <div class="mt-3">
                    @if(auth()->check())
                        <form action="{{url($thread->path().'/replies')}}" method="post">
                            @csrf
                            <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Que voulez-vous dire?"
                                      rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </form>
                    @else
                        <p class="text-center">Veuillez vous <a href="{{route('login')}}">connecter</a> pour participer
                            à cette discussion</p>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>Cette discussion a été publié {{$thread->created_at->diffForHumans()}} par
                            <a href="#">{{$thread->creator->name}}</a>, et a actuellement {{$thread->replies_count}}
                            {{Str::plural('commentaire', $thread->replies_count)}}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
