<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
<p class="text-primary fs-6 mb-0">{{$bid->rdate()}}</p>
<p class="text-primary fs-5 mb-0 ml-sm-auto"> @if(Auth::check() && Auth::user()->id == $bid->authorid)(You)@endif {{$bid->value}}$</p>
</li>