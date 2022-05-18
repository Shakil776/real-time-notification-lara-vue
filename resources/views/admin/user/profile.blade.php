@extends('admin.master')

@section('title', 'Profile')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-8">
                    <h2 class="content-header-title float-left">Account Settings</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.view')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Account Settings
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-body">
        <!-- account setting page -->
        <section id="page-account-settings">
            <div class="row">
                <!-- left menu section -->
                <div class="col-md-3 mb-2 mb-md-0">
                    <ul class="nav nav-pills flex-column nav-left">
                        <!-- general -->
                        <li class="nav-item">
                            <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                <i data-feather="user" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">General</span>
                            </a>
                        </li>
                         <!-- information -->
                        <!-- <li class="nav-item information">
                            <a class="nav-link" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                                <i data-feather="info" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">Information</span>
                            </a>
                        </li> -->
                        
                        <!-- change password -->
                        <li class="nav-item">
                            <a class="nav-link" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                <span class="font-weight-bold">Change Password</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!--/ left menu section -->

                <!-- right content section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- general tab -->
                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">

                                    <!-- header media -->
                                    <div class="media">

                                        @if(!empty($user['image']))
                                            <a class="mr-25">
                                                <img src="{{ asset('uploads/profileImage/'.$user['image']) }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                            </a>
                                        @else
                                            <a class="mr-25">
                                                <img src="{{ asset('admin/assets/img/default.png') }}" id="account-upload-img" class="rounded mr-50" alt="profile image" height="80" width="80" />
                                            </a>
                                        @endif

                                        <!-- upload and reset button -->
                                        <div class="media-body mt-75 ml-1">
                                            <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Change Profile Image</label>
                                            <input type="file" id="account-upload" hidden accept=".png, .jpg, .jpeg" name="image" />
                                            <p>Allowed JPG, JPEG or PNG. Max size of 500KB</p>
                                        </div>
                                        <!--/ upload and reset button -->
                                    </div>
                                    <!--/ header media -->

                                    <!-- form -->
                                    <form class="validate-form mt-2">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="account-name">Name</label>
                                                    <input type="text" class="form-control"  readonly="readonly" value="{{ $user['name'] }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="account-e-mail">E-mail</label>
                                                    <input type="email" class="form-control" readonly="readonly" value="{{ $user['email'] }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="account-company">Mobile</label>
                                                    <input type="text" readonly="readonly" class="form-control" value="{{ $user['mobile'] }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ form -->
                                </div>
                                <!--/ general tab -->

                                <!-- information -->
                                <!-- <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                   
                                    <form class="validate-form">
                                        <div class="row">

                                            <div class="form-group col-12 col-md-6">
                                                <label class="form-label" for="country">Country</label>
                                                <select class="select2 cityByCountry" name="country_id" id="country">
                                                    <option label=" "></option>
                                                    
                                                </select>

                                            </div>

                                            <div class="form-group col-12 col-md-6">
                                                <label class="form-label" for="city">City</label>
                                                <input type="hidden" id="city_id" value="">
                                                <select class="select2" name="city_id" id="city">
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-primary mt-1 mr-1">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div> -->
                                <!--/ information -->

                                <!-- change password -->
                                <div class="tab-pane fade" id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                    <!-- form -->
                                    <form class="validate-password-form" method="POST">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="account-old-password">Current Password</label>
                                                    <div class="input-group form-password-toggle input-group-merge">
                                                        <input type="password" class="form-control" id="account-old-password" name="current_password" placeholder="Old Password" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text cursor-pointer">
                                                                <i data-feather="eye"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="account-new-password">New Password</label>
                                                    <div class="input-group form-password-toggle input-group-merge">
                                                        <input type="password" id="account-new-password" name="new_password" class="form-control" placeholder="New Password" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text cursor-pointer">
                                                                <i data-feather="eye"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label for="account-retype-new-password">Retype New Password</label>
                                                    <div class="input-group form-password-toggle input-group-merge">
                                                        <input type="password" class="form-control" id="account-retype-new-password" name="password_confirmation" placeholder="Retype New Password" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-1 mt-1" id="changePassword">Save changes</button>
                                                <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--/ form -->
                                </div>
                                <!--/ change password -->
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ right content section -->
            </div>
            
        </section>
        <!-- / account setting page -->
    </div>
</div>
@endsection

@push('js')
    @include('admin.user.users_js')
@endpush