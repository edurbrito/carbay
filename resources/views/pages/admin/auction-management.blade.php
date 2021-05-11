<label for="search" class="form-label text-primary">Search:</label>
<input type="text" class="form-control w-100" id="auction-management-search-input" placeholder="Type Something">

<div class="container-fluid px-0 my-3">
    <ol class="list-group rounded-0" id="auction-management-list">
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
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Dismiss" data-bs-toggle="modal" data-bs-target="#suspend" role="button" data-bs-toggle="modal" data-bs-target="#reschedule" role="button">Reschedule</button>
        </div>
      </div>
    </div>
  </div>
</div>