<label for="search" class="form-label text-primary">Search:</label>
<input type="text" class="form-control w-100" id="search" placeholder="Type Something">

<div class="container-fluid px-0 my-3">
    <ol class="list-group rounded-0" id="user-management-list">
    </ol>
    <div class="my-3" id="user-management-pagination" data-page="1">
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ban-user" tabindex="-1" aria-labelledby="ban-user" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">
          <span id="ban-text">You are going to ban X.</span>
        <form id="ban-form"  class="d-flex justify-content-end" method="post" action="/admin/ban/">
          {{ csrf_field() }}
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Dismiss" data-bs-toggle="modal" data-bs-target="#ban-user" role="button">Ban</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="make-admin" tabindex="-1" aria-labelledby="make-admin" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">
          <span id="make-admin-text">You are going to promote X to admin.</span>
        <form id="make-admin-form" class="d-flex justify-content-end mt-4" method="post" action="/admin/make/">
          {{ csrf_field() }}
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button class="btn btn-success" data-bs-dismiss="modal" aria-label="Make Admin" data-bs-toggle="modal" data-bs-target="#make-admin" role="button" data-bs-toggle="modal" data-bs-target="#make-admin" type="submit">Make Admin</button>
        </form>
      </div>
    </div>
  </div>
</div>