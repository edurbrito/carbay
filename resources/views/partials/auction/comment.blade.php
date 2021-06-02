<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
    <div class="d-flex w-100 mb-1">
        <div class="mr-auto">
            <a class="text-primary fs-5 mb-0 float-left" href="/users/{{$comment->author->username}}">{{$comment->author->username}}</a>
            @if(Auth::check() && Auth::user()->id != $comment->author->id)
            <span class="report-button align-self-center" data-id="{{ $comment->id }}" data-location="3" data-username="{{$comment->author->username}}" style="cursor: pointer;">
                <i style="color: red;" class="far fa-flag ml-2" data-bs-toggle="modal" data-bs-target="#report-user" role="button"></i>
            </span>
            @endif
        </div>
        <p class="text-primary fs-6 mb-0 text-right float-right">{{$comment->rdate()}}</p>
    </div>
    <p class="w-100 text-primary mb-0">{{$comment->text}}</p>
</li>