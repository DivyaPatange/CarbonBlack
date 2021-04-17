<!DOCTYPE html>
<html lang="en">
<head>
  <title>CARBON BLACK EDUCATION | REGISTER</title>
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
      width: 100%;
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
          <div class="col-md-6 box py-3">
            <div>
              <h3 class="text-center py-2 bnkgothl">NEW ACCOUNT</h3>
            </div>
            <form method="POST" action="{{ route('register') }}">
				    @csrf
              <div class="px-md-5">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="FULLNAME" value="{{ old('name') }}" autocomplete="name" autofocus> 
    						@if ($errors->has('name'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                </div>
                @endif
                <br>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="EMAIL ADDRESS" value="{{ old('email') }}" autocomplete="email">
							  @if ($errors->has('email'))
                <div>
                  <span class="text-danger" role="alert">{{ $errors->first('email') }}</span>
                </div>
                @endif
                <br>
                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="MOBILE NUMBER" value="{{ old('phone') }}">
							  @if ($errors->has('phone'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('phone') }}</strong></span>
                </div>
                @endif
						    <br>
						    <select id="designation" class="form-control @error('designation') is-invalid @enderror" name="designation" placeholder="DESIGNATION">
                  <option value="">SELECT DESIGNATION</option>
                  <option value="Sr. Manager" @if(old('designation') == "Sr. Manager") Selected @endif>SR. MANAGER</option>
                  <option value="Manager" @if(old('designation') == "Manager") Selected @endif>MANAGER</option>
                  <option value="Sr. Engineer" @if(old('designation') == "Sr. Engineer") Selected @endif>SR. ENGINEER</option>
                  <option value="Engineer" @if(old('designation') == "Engineer") Selected @endif>ENGINEER</option>
                  <option value="Trainee" @if(old('designation') == "Trainee") Selected @endif>TRAINEE</option>
                </select>
							  @if ($errors->has('designation'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('designation') }}</strong></span>
                </div>
                @endif
                <br>
						    <select id="work_experience" class="form-control @error('work_experience') is-invalid @enderror" name="work_experience">
                  <option value="">SELECT WORK EXPERIENCE</option>
                  <option value="0-2" @if(old('designation') == "0-2") Selected @endif>0-2</option>
                  <option value="2-5" @if(old('designation') == "2-5") Selected @endif>2-5</option>
                  <option value="5-10" @if(old('designation') == "5-10") Selected @endif>5-10</option>
                  <option value="10-15" @if(old('designation') == "10-15") Selected @endif>10-15</option>
                </select>
							  @if ($errors->has('work_experience'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('work_experience') }}</strong></span>
                </div>
                @endif
                <br>
						    <input id="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" placeholder="EMPLOYEE ID" value="{{ old('employee_id') }}">
							  @if ($errors->has('employee_id'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('employee_id') }}</strong></span>
                </div>
                @endif
						    <br>
						    <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" placeholder="DEPARTMENT" value="{{ old('department') }}">
							  @if ($errors->has('department'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('department') }}</strong></span>
                </div>
                @endif
                <br>
                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="CITY" value="{{ old('city') }}">
							  @if ($errors->has('city'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('city') }}</strong></span>
                </div>
                @endif
						    <br>
						    <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" placeholder="STATE" value="{{ old('state') }}">
							  @if ($errors->has('state'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('state') }}</strong></span>
                </div>
                @endif
						    <br>
						    <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" placeholder="COUNTRY" value="{{ old('country') }}">
							  @if ($errors->has('country'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('country') }}</strong></span>
                </div>
                @endif
						    <br>
						    <input id="pin" type="text" class="form-control @error('pin') is-invalid @enderror" name="pin" placeholder="POSTAL ZIP CODE" value="{{ old('pin') }}">
							  @if ($errors->has('pin'))
    						<div>
                  <span class="text-danger" role="alert"><strong>{{ $errors->first('pin') }}</strong></span>
                </div>
                @endif
						    <br>
						    {{-- acc_type hidden --}}
						    <input type="hidden" name="acc_type" value="user">
						    {{-- //acc_type hidden --}}
						    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="PASSWORD" name="password" autocomplete="new-password">
							  @if ($errors->has('password'))
    						<div>
                  <span class="text-danger" role="alert">{{ $errors->first('password') }}</span>
                </div>
                @endif
						    <br>
						    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="CONFIRM PASSWORD" autocomplete="new-password">
					
                
                <br>
						    <div class="form-group form-check"> 
                  <label class="form-check-label bnkgothl">
                    <input class="form-check-input " name="terms_and_condition" type="checkbox">I AGREE TO THE TERMS AND CONDITIONS
                    @if ($errors->has('terms_and_condition'))
    						    <div>
                      <span class="text-danger" role="alert">{{ $errors->first('terms_and_condition') }}</span>
                    </div>
                    @endif
                  </label>
                </div>
                <button class="btn-block bnkgothl" type="submit">SIGN UP</button>
              </div>
            </form>
          </div>
          <div class="col-md-6 py-3">
            <div class="my-5 py-5 px-5">
              <h4 class="bnkgothl">CARBON BLACK EDUCATION IS THE VIRTUAL PLATFORM FOR TRAINING OPERATORS, ENGINEERS AND PROFESSIONALS.</h4>
              <h4 class="bnkgothl">COMPLETE THE NEW ACCOUNT FORM TO REQUEST AN ACCOUNT.</h4>
              <!--<h4>PLEASE MAKE SURE TO PROVIDE YOUR "WORKED EMAIL ADDRESS" WHERE ASKED.</h4>-->
              <h4 class="bnkgothl">ALREADY, HAVE AN ACCOUNT ?<a href="{{ route('login') }}"> SIGN IN</a></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</div>

</body>
</html>
