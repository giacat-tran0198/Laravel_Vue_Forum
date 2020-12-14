@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Créer un nouvelle discussion</div>

                    <div class="card-body">
                        <form action="{{route('threads.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Choisissez une chaîne</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choisissez une...</option>
                                    @foreach(\App\Models\Channel::all() as $channel)
                                        <option
                                            value="{{$channel->id}}" {{old('channel_id')== $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Titre:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="titre"
                                       value="{{old('title')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="body">Description:</label>
                                <textarea name="body" id="body" rows="10"
                                          class="form-control" required>{{old('body')}}</textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publier</button>
                            </div>
                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
