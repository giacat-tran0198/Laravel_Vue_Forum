@extends('layouts.app')

@section('content')
    <thread-view inline-template :initial-replies-count="{{$thread->replies_count}}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                            <span class="flex">
                            <a href="{{route('profiles', $thread->creator)}}">{{$thread->creator->name}}</a> a publié:
                            {{$thread->title}}
                            </span>
                                @can('update', $thread)
                                    <form action="{{$thread->path()}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            {{$thread->body}}
                        </div>
                    </div>
                    <replies :data="{{$thread->replies}}" @removed="repliesCount--"></replies>
                    {{--                {{$replies->links()}}--}}
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
                            <p class="text-center">Veuillez vous <a href="{{route('login')}}">connecter</a> pour
                                participer
                                à cette discussion</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>Cette discussion a été publié {{$thread->created_at->diffForHumans()}} par
                                <a href="#">{{$thread->creator->name}}</a>, et a actuellement <span v-text="repliesCount"></span>
                                {{Str::plural('commentaire', $thread->replies_count)}}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
