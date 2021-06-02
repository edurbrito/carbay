<label for="search" class="form-label text-primary">Search:</label>
<input type="text" class="form-control w-100" id="auction-management-search-input" placeholder="Type Something">
@if ($errors->has('auctions'))
<div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show my-3 p-1 px-2" style="width: fit-content;" role="alert">
{{ $errors->first('auctions') }}
</div>
@elseif(!is_null(session('success.auctions')))
<div onclick="this.hidden = true" class="alert alert-success alert-dismissible fade show my-3 p-1 px-2" style="width: fit-content;" role="alert">
{{ session('success')["auctions"] }}
</div>
@endif
<div class="container-fluid px-0 my-3">
    <ol class="list-group rounded-0" id="auction-management-list">
      <div class="spinner-border align-self-center" role="status"><span class="sr-only">Loading...</span></div>
    </ol>
    <div class="my-3" id="auction-management-pagination" data-page="1">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="suspend" tabindex="-1" aria-labelledby="suspend" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">
          <span id="suspend-text">You are going to suspend auction X.</span>
        <form id="suspend-form" class="d-flex justify-content-end pt-2" method="post" action="/admin/suspend/">
            {{ csrf_field() }}
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Dismiss" data-bs-toggle="modal" data-bs-target="#suspend" role="button">Suspend</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reschedule" tabindex="-1" aria-labelledby="reschedule" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">
        <form id="reschedule-form" method="post" action="/admin/reschedule/">
            {{ csrf_field() }}
            <span id="reschedule-text" class="w-100">This auction is planned to end at ....</span>
            <div class="input-group input-group-sm pt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text rounded-0" id="duration">Postpone it by:</span>
                </div>
                <input type="number" name="duration" min="1" max="15" class="form-control" aria-label="Small" aria-describedby="duration" value="1" required>
                <div class="input-group-prepend">
                    <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">Days</span>
                </div>
            </div>
            <span class="text-danger mb-3" style="font-size: 0.75rem">* Maximum duration from initial date can only be 15 days.</span>
            <div class="d-flex justify-content-end pt-2">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-danger" role="button">Postpone</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>