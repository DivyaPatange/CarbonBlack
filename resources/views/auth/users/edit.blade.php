<!DOCTYPE html>
<html lang="en">
<head>
  <title>CARBON BLACK EDUCATION | Edit Administrator</title>
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
span{
    font-family: BNKGOTHL !important;
}
    body{
      background-color: black;
    }
    .card{
      background-color: black;
      color: white;
    }
    .box{
       border: 1px solid #2e75b6;  
    }
    .form-control{
      background-color: black;
      color: white;
      border: 1px solid #2e75b6;
    }
    button{
      background-color: #2e75b6;
      color: white;
      border: none;
      padding: 10px;
    }
    input::placeholder {
  font-family: BNKGOTHL !important;
  }
  
  input{
      font-family:sans-serif !important;
  }
    /*.card-header{*/
    /*  border:1px solid #2e75b6;*/
    /*  padding: 0.75rem */
    /*}*/
  </style>
</head>
<body>
  
<div class="container">
    <div class="logo mt-3">
         <a href="https://carbonblack.education/"><img src="{{ URL::asset('assets/frontend/img/logo/logo.png') }}" alt="logo" class="img-fluid" style="height:70px;"></a>
         <h3 class="text-light bnkgothl">Carbon Black <br> <span>Education</span></h3>
      </div>
  <div class="col-md-10 m-auto py-5">
    <div class="card">
      <div class="card-header">
        <!--<h1 class="text-center py-2">CARBON BLACK EDUCATION</h1>-->
      </div>
      <div class="card-body">
        <div class="row py-5">
          <div class="col-md-12 box py-3">
            <div>
              <h3 class="text-center py-2 bnkgothl">SIGN UP</h3>
            </div>
            <form method="POST" action="{{ route('adminReg.user.update', $adminReg->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
                  <div class="px-md-5 col-md-6 col-12 col-lg-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="COMPANY NAME" value="{{ $adminReg->name }}" autocomplete="name" autofocus> 
              @if ($errors->has('name'))
              <div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
            </div>
            @endif
                    <br>
                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="MOBILE NUMBER" value="{{ $adminReg->phone }}">
            @if ($errors->has('phone'))
              <div>
              <span class="text-danger" role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
            </div>
            @endif
            <br>
            <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" placeholder="DEPARTMENT" value="{{ $adminReg->department }}">
            @if ($errors->has('department'))
              <div>
              <span class="text-danger" role="alert"><strong>{{ $errors->first('department') }}</strong></span>
            </div>
            @endif
            <br>
            <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" placeholder="STATE" value="{{ $adminReg->state }}">
            @if ($errors->has('state'))
              <div>
              <span class="text-danger" role="alert"><strong>{{ $errors->first('state') }}</strong></span>
            </div>
            @endif
            <br>
            <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" placeholder="POSTAL ZIP CODE" value="{{ $adminReg->pin }}">
            @if ($errors->has('pin'))
              <div>
                        <span class="text-danger" role="alert"><strong>{{ $errors->first('pin') }}</strong></span>
            </div>
            @endif
            <br>
            <br>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="PASSWORD" value="">
            <input type="hidden" name="hidden_password" value="{{ $adminReg->password }}">
            @if ($errors->has('password'))
              <div>
              <span class="text-danger" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
            </div>
            @endif
          </div>
          <div class="px-md-5 col-md-6 col-12 col-lg-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="EMAIL ADDRESS" value="{{ $adminReg->email }}" autocomplete="email">
            @if ($errors->has('email'))
            <div>
              <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
            </div>
            @endif  
            <br>    
            <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" placeholder="DESIGNATION" value="{{ $adminReg->designation }}">
            @if ($errors->has('designation'))
              <div>
              <span class="text-danger" role="alert"><strong>{{ $errors->first('designation') }}</strong></span>
            </div>
            @endif
            <br>
                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="CITY" value="{{ $adminReg->city }}">
            @if ($errors->has('city'))
              <div>
              <span class="text-danger" role="alert"><strong>{{ $errors->first('city') }}</strong></span>
            </div>
            @endif
            <br>
            <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" placeholder="COUNTRY" value="{{ $adminReg->country }}">
            @if ($errors->has('country'))
              <div>
                        <span class="text-danger" role="alert"><strong>{{ $errors->first('country') }}</strong></span>
            </div>
            @endif
            <br>
            <input id="logo" type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">
            
            @if ($errors->has('logo'))
            <div>
              <span class="text-danger" role="alert">
                <strong>{{ $errors->first('logo') }}</strong>
              </span>
            </div>
            @enderror
            <br>
            @if(!empty($logo))
            <div class="styled-input">
              <a href="{{ URL::to('/') }}/logo/{{$logo->logo}}" target="_blank">Click to View</a>
            </div>
            <input type="hidden" name="hidden_image" value="{{$logo->logo}}">
            @endif
            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="CONFIRM PASSWORD" value="">
          <div>
        </div>
        </div>
        </div>
        <br>
        <br>
        <div class="row">
          <div class="col-12 text-center">
          
                    <button class="bnkgothl" type="submit" style="display:inline-block">UPDATE</button>
                    
          </div>
        </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  
</div>

</body>
</html>
