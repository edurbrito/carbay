<?php
include_once(__DIR__ . "/templates/header-logged-in.php");
breadcrum();
?>

<div class="container-fluid mx-auto mb-0 mb-sm-4">
  <h1 class="w-100 text-light p-md-4 text-center">Edit Profile</h1>
</div>

<!-- Grid row -->
<div class="row text-center">
  <!-- Grid column -->
  <div class="col-md-6 mb-5 mb-md-0 align-self-center">
    <!-- Section: Photo and Username -->
    <section class="container text-center">
        <h3 class="font-weight-bold dark-grey-text my-4 text-light">johndoe123</h3>
        <div class="avatar mx-auto col-md-12 position-relative mb-4 p-0">
          <img src="https://www.droege-group.com/fileadmin/_processed_/4/0/csm_joerg.kieborz_67255b87b6.jpg" class="rounded z-depth-1-half img-fluid" alt="Sample avatar" style="min-height:300px;height:300px;min-width:300px;width:300">
        </div>
        <a href="/../profile.php"><button class="btn btn-secondary">Upload Photo</button></a>
    </section>
  </div>
  <!-- Grid column -->
  <div class="col-md-6 mb-md-0 align-self-center">
    <!-- Section: Profile Data -->
    <div class="container h-100">
      <div class="d-flex justify-content-center h-100">
        <div class="d-flex justify-content-center">
          <form>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text rounded-0"><i class="fas fa-id-card"></i></span>
              </div>
              <input type="text" name="" class="form-control" value="" placeholder="Name">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text rounded-0"><i class="fas fa-at"></i></span>
              </div>
              <input type="text" name="" class="form-control" value="" placeholder="Email">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" name="" class="form-control" value="" placeholder="Old Password">
            </div>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" name="" class="form-control" value="" placeholder="New Password">
            </div>
            <div class="input-group mb-2">
              <div class="input-group-append">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
              </div>
              <input type="text" name="" class="form-control" value="" placeholder="Repeat New Password">
            </div>
            <div class="d-flex justify-content-center mt-3">
              <button class="btn btn-dark text-center mr-3" type="button" name="button" class="btn">Discard Changes</button>
              <button class="btn btn-success text-light text-center " type="button" name="button" class="btn">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid column -->
</div>
<!-- Grid row -->

<?php
include_once(__DIR__ . "/templates/footer.php");
?>