<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
<div class="d-flex w-100 mb-1">
<a class="text-primary fs-5 mb-0 float-left" href="/users/{{$comment->author->username}}">{{$comment->author->username}}</a>
@if(Auth::check())<span class="report-button" data-id="{{ $comment->id }}" style="cursor: pointer;"><i class="far fa-flag ml-2 fs-5 mb-0 float-left mr-auto" data-bs-toggle="modal" data-bs-target="#report-user" role="button"></i></span>@endif
<p class="text-primary fs-6 mb-0 text-right float-right">{{substr($comment->datehour, 0, -6)}}</p>
</div>
<p class="w-100 text-primary mb-0">{{$comment->text}}</p>
</li>