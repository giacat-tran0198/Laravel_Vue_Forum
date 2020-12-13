@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Créer un nouveau sujet</div>

                    <div class="card-body">
                        <form action="{{route('threads.store')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="title">Titre:</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="titre">
                            </div>
                            <div class="form-group">
                                <label for="body">Description:</label>
                                <textarea name="body" id="body" rows="10" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
