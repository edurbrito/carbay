<li class="list-group-item">
    <div class="d-flex align-items-center justify-content-start rounded-0 flex-vertical">
        <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/users/{{ $report->reported()->username }}">
            <img src="{{ $report->reported()->image }}" width="36px">
            <span class="text-primary ml-3">{{ $report->reported()->username }}</span>
        </a>
        <div class="btn-group ml-sm-auto" role="group" aria-label="User Management Buttons">
            <button type="button" class="btn btn-danger mr-1 user-report-ban-button" data-bs-toggle="modal" data-bs-target="#report-ban-user" role="button" data-username="{{ $report->reported()->username }}" data-id="{{ $report->id }}">Ban</button>
            <button type="button" class="btn btn-primary user-report-discard-button" data-bs-toggle="modal" data-bs-target="#discard" role="button" data-username="{{ $report->reported()->username }}" data-id="{{ $report->id }}">Discard</button>
        </div>
    </div>
    <p class="mt-3 text-primary text-justify"><span class="text-primary fs-6">Location: </span><a href="{{$report->location()['url']}}">{{ $report->location()["location"] }}</a> </p>
    <p class="mt-3 text-primary text-justify"><span class="text-primary fs-6">Reason: </span>{{ $report->reason }}</p>
</li>