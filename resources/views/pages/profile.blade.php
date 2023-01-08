@extends('layouts.layout')

@section('content')

<form action="profile/profileHandler" method="POST" enctype="multipart/form-data">
    @csrf

    @include('layouts.info')

    <div class="row">
        <div class="col d-flex justify-content-center pt-4">
            <div class="card pb-3" style="width: 20rem;" ondragover="dragover(event)" ondrop="drop(event)">
                <img src="{{ !empty(Auth::user()->profile_image) ? asset('storage/img/profile/'.Auth::user()->profile_image): asset('storage/img/other/cloud-upload.svg') }}"
                width="256" height="256" draggable="false" id="displayImg" class="mx-auto p-3 rounded-circle" alt="Responsive image">

                <div class="card-body">
                    <h5>Upload profile image</h5>
                    <p>Upload image form your device or just drop it in the drop zone</p>

                    <input type="file" id="upload" name="profile_image" accept=".jpg,.jpeg,.svg,.png" onchange="displayImage(this.files[0])" hidden>
                    <button type="button" id="btnUpload" class="btn btn-outline-primary w-75 mx-auto" onclick="clickUpload()">Upload</button>
                    <div class="invalid-feedback" id="errorMsg"></div>
                </div>
            </div>
        </div>

        <div class="col d-flex justify-content-center pt-4">
        <div class="card mx-auto" style="width: 36rem;">
            <div class="card-header">
              <h3>Profile</h3>
            </div>
            <div class="card-body">

        <div class="d-flex flex-column justify-content-end text-start">
            <div class="d-flex gap-5">
                <div class="mb-3 col">
                    <label for="firstName" class="form-label">First name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" value="{{ Auth::user()->first_name }}" maxlength="32" aria-describedby="firstName" pattern="^[A-Za-z]*$" title="First name must contains letter only">
                </div>
                <div class="mb-3 col">
                    <label for="lastName" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" value="{{ Auth::user()->last_name }}" maxlength="32" aria-describedby="lastName" pattern="^[A-Za-z]*$" title="Last name must contains letter only">
                </div>
            </div>

            <div class="d-flex gap-5 justify-content-between">
                <div class="mb-3 col">
                    <label for="birthDate" class="form-label">Date of birth</label>
                    <input type="date" class="form-control" id="birthDate" name="birth_date" value="{{ Auth::user()->birth_date }}" min='1899-01-01' max='2000-13-13' aria-describedby="birthDate">
                </div>
                <div class="mb-3 col">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" aria-describedby="gender">
                        @if (Auth::user()->gender == 'male')
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                        @elseif (Auth::user()->gender == 'female')
                            <option value="male">Male</option>
                            <option value="female" selected>Female</option>
                        @else
                            <option disabled selected hidden>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country" aria-describedby="country">
                    <option disabled selected hidden>Select country</option>
                    @php
                        foreach ($countries as $country) {
                            if (Auth::user()->country_id == $country->id){
                                echo '<option value="'.$country->id.' selected">'.$country->name.'</option>';
                            }
                            else{
                                echo '<option value="'.$country->id.'">'.$country->name.'</option>';
                            }
                        }
                    @endphp
                </select>
            </div>
        </div>

        <div class="row px-3 py-2 gap-5">
            <a type="submit" class="btn btn-outline-primary col" href="/changeEmail">Change Email</button>
            <a type="submit" class="btn btn-outline-primary col" href="/forgotPassword">Reset Password</a>
        </div>

        <div class="row px-3 py-2 gap-5">
            <button type="button" class="btn btn-outline-danger col" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Delete Account
              </button>
              
              <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="staticBackdropLabel">Delete Account</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Are you sure you want to delete your account?
                      If you delete your account, you will permanently lose all your data.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" name="profile_action" value="delete" class="btn btn-danger">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
              
              <button type="submit" name="profile_action" value="save" class="btn btn-outline-success col">Save Changes</button>
        </div>

        </div>
        </div>
        </div>
    </div>
</form>

@stop