<!DOCTYPE html>
<html lang="en">
<head>
  <title>CARBON BLACK EDUCATION | LOGIN</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style type="text/css">
  @font-face {
   font-family: BNKGOTHL;
   src: url(public/assets/frontend/css/font/BNKGOTHL.ttf);
}
  * {
    font-family: BNKGOTHL !important;*/
  }
  .bnkgothl {
    font-family: BNKGOTHL !important;
  }
    body{
      background-color: black;
    }
    .card{
      background-color: black;
      color: white;
      border: 1px solid #2e75b6; 
    }
    .form-control{
      background-color: black;
      color: white;
      border: 1px solid #2e75b6;
    }
    .loginbutton{
      background-color: #2e75b6;
      width: 100%;
      color: white;
      border: none;
      padding: 10px;
    }
    .card-header{
      border:1px solid #2e75b6;
      padding: 0.75rem 
    }
    input::placeholder {
  font-family:BNKGOTHL !important;
    }
    input{
        font-family: sans-serif !important;
    }
  </style>
</head>
<body>
  
<div class="container">
    <div class="logo mt-3">
         <a href="https://carbonblack.education/"><img src="{{ URL::asset('assets/frontend/img/logo/logo.png') }}" alt="logo" class="img-fluid" style="height:70px;"></a>
         <h3 class="text-light bnkgothl">Carbon Black <br> <span>Education</span></h3>
      </div>
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
  <div class="col-md-10 m-auto py-5">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center py-2 bnkgothl">CARBON BLACK EDUCATION</h2>
      </div>
      <div class="card-body">
        <div class="row py-5">
          <div class="col-md-6">
              <form method="POST" action="{{ route('login') }}">
                @csrf
                    <div class="px-md-5">
                    <!--<input type="text" name="username" class="form-control" placeholder="USERNAME">-->
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="EMAIL" autofocus>
                        @if ($errors->has('email'))
    						<div>
                                <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                            </div>
                            @endif
                    <br>
                    <!--<input type="password" name="password" class="form-control" placeholder="PASSWORD">-->
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="PASSWORD">
                        @if ($errors->has('password'))
    						<div>
                                <span class="text-danger" role="alert">{{ $errors->first('password') }}</span>
                            </div>
                            @endif
                    <br>
                    <br>
                    <div class="form-group form-check">
                      <label class="form-check-label bnkgothl">
                        <input class="form-check-input bnkgothl" type="checkbox" name="remember">REMEMBER EMAIL
                        @if ($errors->has('remember'))
    						<div>
                                <span class="text-danger" role="alert">{{ $errors->first('remember') }}</span>
                            </div>
                            @endif
                      </label>
                    </div>
                    <br>
                    <button type="submit" name="login" class="bnkgothl loginbutton">LOG IN</button>
                  </div>
             </form>
          </div>
          <div class="col-md-6">
            <div class="px-md-5">
              <a href="{{ url('/resetPassword') }}" class="bnkgothl">FORGOTTEN YOUR PASSWORD?</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="px-md-5 pb-5">
              <p class="bnkgothl">DON'T HAVE AN ACCOUNT ? </p><a href="{{ route('register') }}" class="bnkgothl"> SIGN UP</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>

</body>
</html>
