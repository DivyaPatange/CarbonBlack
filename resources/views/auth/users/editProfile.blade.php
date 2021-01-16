@extends('auth.admin_layouts.main')

@section('title','Dashboard')

@section('customcss')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
<style>
    .hidden{
        display:none;
    }
    .kbw-signature { width: 100%; height: 200px;}

    #sig canvas{

        width: 100% !important;

        height: auto;

    }
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
                    <h2><b>Edit Profile</b></h2>
                    <div class="row">
                      <div class="col-md-12 py-3">
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
                    <form id="changePasswordForm" method="POST" action="{{ route('admin.updateProfile') }}">
                    @csrf 
                    @method('PUT')
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Name</label> 
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                                    @if ($errors->has('name'))
                                    <span class="text-danger error">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                                    @if ($errors->has('email'))
                                    <span class="text-danger error">{{ $errors->first('email') }}</span>
                                @endif
                                </div>
                                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                <div class="form-group col-md-4">
                                    <label for="contact_no">Contact No.</label> 
                                    <input type="number" name="contact_no" class="form-control" id="contact_no" value="{{ $user->phone }}">
                                    @if ($errors->has('contact_no'))
                                    <span class="text-danger error">{{ $errors->first('contact_no') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="designation">Designation</label>
                                    <input type="text" name="designation" class="form-control" id="designation" value="{{ $user->designation }}">
                                    @if ($errors->has('designation'))
                                    <span class="text-danger error">{{ $errors->first('designation') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="department">Department</label>
                                    <input type="text" name="department" class="form-control" id="department" value="{{ $user->department }}">
                                    @if ($errors->has('department'))
                                    <span class="text-danger error">{{ $errors->first('department') }}</span>
                                @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country">Country</label>
                                    <input type="text" name="country" class="form-control" id="country" value="{{ $user->country }}">
                                    @if ($errors->has('country'))
                                    <span class="text-danger error">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="state">State</label>
                                    <input type="text" name="state" class="form-control" id="state" value="{{ $user->state }}">
                                    @if ($errors->has('state'))
                                    <span class="text-danger error">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">City</label>
                                    <input type="text" name="city" class="form-control" id="city" value="{{ $user->city }}">
                                    @if ($errors->has('city'))
                                    <span class="text-danger error">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="pin">Pin Code</label>
                                    <input type="number" name="pin_code" class="form-control" id="pin" value="{{ $user->pin }}">
                                    @if ($errors->has('pin_code'))
                                    <span class="text-danger error">{{ $errors->first('pin_code') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="" for="">Signature:</label>
                                    <br/>
                                    <div id="sig" ></div>
                                    <br/>
                                    <button id="clear" class="mdc-button mdc-button--raised filled-button--secondary mdc-ripple-upgraded" style="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.92922; --mdc-ripple-fg-translate-start:-9.5px, -7.5px; --mdc-ripple-fg-translate-end:22.3203px, -14.5px;">
                                    Clear Signature
                                    </button>   

                                    <textarea id="signature64" name="signed" style="display: none"></textarea>

                                </div>
                                @if(!empty($userInfo->signature_img))
                                <div class="form-group col-md-12">
                                    <a href="{{ URL::asset('/upload/' . $userInfo->signature_img) }}" target="_blank">Click to View</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary" id="updatePassword">Update Profile</button>
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
@section('customjs')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
<script type="text/javascript">

    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});

    $('#clear').click(function(e) {

        e.preventDefault();

        sig.signature('clear');

        $("#signature64").val('');

    });

</script>
@endsection