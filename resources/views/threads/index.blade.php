@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum - Tous les sujets</div>

                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <h3>
                                    <a href="{{$thread->path()}}">{{$thread->title}}</a>
                                </h3>
                                <div class="card-body">{{$thread->body}}</div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
