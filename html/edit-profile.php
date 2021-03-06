<?php
  include_once(__DIR__ . "/templates/header-logged-in.php");
  breadcrum();
?>

<div class="container-fluid mx-auto mb-5">
    <h1 class="w-100 text-light p-md-4 text-center">Edit Profile</h1>
</div>

<!-- Grid row -->
<div class="row text-center">
  <!-- Grid column -->
  <div class="col-md-6 mb-md-0">
    <!-- Section: Photo and Username -->
    <section class="container text-center">
      <div class="col-md-12 mb-md-0">
        <div class="avatar mx-auto col-md-12 position-relative">
          <img src="https://www.droege-group.com/fileadmin/_processed_/4/0/csm_joerg.kieborz_67255b87b6.jpg" class="rounded z-depth-1-half img-fluid" alt="Sample avatar" style="min-height:300px;height:300px;min-width:300px;width:300">
          <a type="button" class="border rounded-circle p-2 position-absolute" href="../edit-profile.php"><i class="fas fa-pencil-alt fa-3x text-light"></i></a>
        </div>
        <h3 class="font-weight-bold dark-grey-text my-4 text-light">johndoe123</h3>
      </div>
    </section>
  </div>
  <!-- Grid column -->
  <div class="col-md-6 mb-md-0">
    <!-- Section: Profile Data -->
    <div class="container h-100">
      <div class="d-flex justify-content-center h-100">
        <div class="user_card">
          <div class="d-flex justify-content-center form_container">
            <form>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <input type="text" name="" class="form-control input_user" value="" placeholder="Name">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-at"></i></span>
                </div>
                <input type="text" name="" class="form-control input_user" value="" placeholder="Email">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="" class="form-control input_pass" value="" placeholder="Old Password">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="" class="form-control input_pass" value="" placeholder="New Password">
              </div>
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="text" name="" class="form-control input_user" value="" placeholder="Repeat New Password">
              </div>
                <div class="d-flex justify-content-center mt-3 login_container">
                  <button class="btn btn-dark text-light text-center mr-3" type="button" name="button" class="btn login_btn">Save Changes</button>
                  <button class="btn btn-dark text-light text-center" type="button" name="button" class="btn login_btn">Discard Changes</button>
              </div>
            </form>
          </div>
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