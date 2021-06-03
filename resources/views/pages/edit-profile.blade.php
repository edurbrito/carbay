@extends('layouts.content')

@push('scripts')
<script src="{{ asset('js/edit-profile.js') }}" defer></script>
@endpush

@section('div_content')

<div class="container-fluid mx-auto mb-0 mb-sm-4">
  <h1 class="w-100 p-md-4 text-center">Edit Profile</h1>
</div>

<form method="POST" action="/users/{{ $user->username }}/edit" enctype="multipart/form-data">
  {{ csrf_field() }}
  <!-- Grid row -->
  <div class="row text-center">
    <!-- Grid column -->
    <div class="col-md-6 mb-5 mb-md-0 align-self-center">
      <!-- Section: Photo and Username -->
      <section class="container text-center">
        <h3 class="font-weight-bold dark-grey-text my-4">{{ $user->username }}</h3>
        <div class="avatar mx-auto col-md-12 position-relative mb-4 p-0">
          <img id="profile-photo" src="{{ $user->image }}" class="rounded z-depth-1-half img-fluid" alt="Sample avatar" style="min-height:300px;height:300px;min-width:300px;width:300">
        </div>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" accept="image/*" class="custom-file-input" id="photo-input" name="image-input" value="Upload Photo" style="cursor: pointer;">
            <label class="custom-file-label text-left" for="image-input" style="cursor: pointer;">Upload Photo</label>
          </div>
        </div>
      </section>
    </div>
    <!-- Grid column -->
    <div class="col-md-6 mb-md-0 align-self-center">
      <!-- Section: Profile Data -->
      <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
          <div class="d-flex justify-content-center">
            <div>
              <div class="input-group mb-3" title="Name">
                <div class="input-group-append">
                  <span class="input-group-text rounded-0"><i class="fas fa-id-card"></i></span>
                </div>
                <input type="text" name="name" class="form-control" value="{{ old('name') != null ? old('name') : $user->name }}" placeholder="Name" required>
              </div>
              @if ($errors->has('name'))
              <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
                {{ $errors->first('name') }}
              </div>
              @endif
              <div class="input-group mb-3" title="Email">
                <div class="input-group-append">
                  <span class="input-group-text rounded-0"><i class="fas fa-at"></i></span>
                </div>
                <input type="email" name="email" class="form-control" value="{{ old('email') != null ? old('email') : $user->email }}" placeholder="Email" required>
              </div>
              @if ($errors->has('email'))
              <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
                {{ $errors->first('email') }}
              </div>
              @endif
              <div class="input-group mb-3" title="Current Password">
                <div class="input-group-append">
                  <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="current_password" class="form-control" value="" placeholder="Current Password" required>
              </div>
              @if ($errors->has('current_password') || $errors->has('match'))
              <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
                {{ $errors->first('current_password') }}
                {{ $errors->first('match') }}
              </div>
              @endif
              <div class="input-group mb-3" title="New Password">
                <div class="input-group-append">
                  <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="new_password" class="form-control" value="" placeholder="New Password">
              </div>
              @if ($errors->has('new_password'))
              <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
                {{ $errors->first('new_password') }}
              </div>
              @endif
              <div class="input-group mb-2" title="Confirm New Password">
                <div class="input-group-append">
                  <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="confirm_password" class="form-control" value="" placeholder="Repeat New Password">
              </div>
              @if ($errors->has('confirm_password'))
              <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
                {{ $errors->first('confirm_password') }}
              </div>
              @endif
              <div class="d-flex justify-content-center mt-3">
                <a class="btn btn-dark text-center mr-3" href="/users/{{$user->username}}" class="btn">Discard Changes</a>
                <button class="btn btn-success text-light text-center " type="submit" name="button" class="btn">Save Changes</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Grid column -->
  </div>
  <!-- Grid row -->
</form>

@endsection