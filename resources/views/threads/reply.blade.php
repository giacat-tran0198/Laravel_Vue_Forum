<div class="card my-3">
    <div class="card-header">
        <a href="#">
            {{$reply->owner->name}}
        </a>
        a publié
        {{$reply->created_at->diffForHumans()}}
    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>