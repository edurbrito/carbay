<label for="search" class="form-label text-primary">Search:</label>
<input type="text" class="form-control w-100" id="report-search-input" placeholder="Type Something">
@if ($errors->has('reports'))
<div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show my-3 p-1 px-2" style="width: fit-content;" role="alert">
    {{ $errors->first('reports') }}
</div>
@elseif(!is_null(session('success.reports')))
<div onclick="this.hidden = true" class="alert alert-success alert-dismissible fade show my-3 p-1 px-2" style="width: fit-content;" role="alert">
    {{ session('success')["reports"] }}
</div>
@endif
<div class="container-fluid px-0 my-3">
    <ol class="list-group rounded-0" id="report-list">
    <div class="spinner-border align-self-center" role="status"><span class="sr-only">Loading...</span></div>
    </ol>
    <div class="my-3" id="report-pagination" data-page="1">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="report-ban-user" tabindex="-1" aria-labelledby="report-ban-user" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifications">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-primary">
                <span id="report-ban-text">You are going to ban X.</span>
                <form id="user-report-ban-form" class="d-flex justify-content-end mt-4" method="post" action="/admin/reports/ban">
                    {{ csrf_field() }}
                    <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Ban" data-bs-toggle="modal" data-bs-target="#report-ban-user" role="button">Ban</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="discard" tabindex="-1" aria-labelledby="discard" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifications">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-primary">
                <div class="d-flex justify-content-end">
                    <span id="discard-text">You are going discard this report.</span>
                    <form id="user-report-discard-form" class="d-flex justify-content-end mt-4" method="post" action="/admin/reports/discard/">
                        {{ csrf_field() }}
                        <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Discard" data-bs-toggle="modal" data-bs-target="#discard" role="button" data-bs-toggle="modal" data-bs-target="#discard" role="button">Discard</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>