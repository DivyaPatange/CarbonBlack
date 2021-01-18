@extends('auth.admin_layouts.main')

@section('title','Change Password')

@section('custom_styles')
    <style>
       
    </style>
@endsection

@section('content')
<div class="mdc-layout-grid">
    <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-12 col-lg-12">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <h2><b>Change Password</b></h2>
                    <div class="row">
                      <div class="col-md-6 m-auto py-3">
                          @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                        	<button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        @if ($message = Session::get('danger'))
                        <div class="alert alert-danger alert-block">
                        	<button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                      </div>
                  </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!--<h3> Message Notification </h3>-->
                            <br>
                        </div>
                    </div>
                    <form id="changePasswordForm" method="POST" action="{{ route('ChangePasswordStore') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                 <div class="form-group col-md-2">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="">Old Password</label>
                                    <input type="password" name="old_password" class="form-control" id="oldPassword" value="{{ old('old_password') }}">
                                    @if ($errors->has('old_password'))
                                    <span class="text-danger error">{{ $errors->first('old_password') }}</span>
                                @endif
                                </div>
                                 <div class="form-group col-md-2">
                                </div>
                            </div>
                            <div class="form-row">
                                 <div class="form-group col-md-2">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="">New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="newPassword" >
                                    @if ($errors->has('new_password'))
                                    <span class="text-danger error">{{ $errors->first('new_password') }}</span>
                                @endif
                                </div>
                                 <div class="form-group col-md-2">
                                </div>
                            </div>
                             <div class="form-row">
                                  <div class="form-group col-md-2">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="">Confirm Password</label>
                                    <input type="password" name="renew_password" class="form-control" id="confirmPassword">
                                    @if ($errors->has('renew_password'))
                                    <span class="text-danger error">{{ $errors->first('renew_password') }}</span>
                                @endif
                                </div>
                                 <div class="form-group col-md-2">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary" id="updatePassword">Update Password</button>
                        </div>
                    </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection