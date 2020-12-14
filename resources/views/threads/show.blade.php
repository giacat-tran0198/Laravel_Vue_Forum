@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('threads.index', ['by' => $thread->creator->name])}}">{{$thread->creator->name}}</a> a posté:
                        {{$thread->title}}
                    </div>

                    <div class="card-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8 offset-md-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form action="{{url($thread->path().'/replies')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Que voulez-vous dire?"
                                      rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publier</button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-center">Veuillez vous <a href="{{route('login')}}">connecter</a> pour participer à cette discussion</p>
        @endif
    </div>
@endsection
