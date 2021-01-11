
<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Smooth Sliding Forms template Responsive, Login form web template,Flat Pricing w3tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="{{ URL::asset('login_form/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->

<!-- font-awesome icons -->
<link href="{{ URL::asset('login_form/css/font-awesome.css') }}" rel="stylesheet"> 
<!-- //font-awesome icons -->

<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Cormorant+Unicase:300,400,500,600,700" rel="stylesheet"><!--web font-->
<!-- //web font -->
<style>
.main-agileinfo .agileui-forms .container-info .info-w3lsitem {
display:block;
margin-left:auto;
}
.container-form{
    height: 800px;
}
.agileui-forms .container-info .info-w3lsitem .w3table-cell{
    padding-right:0px;
}
strong{
    color:red;
}
</style>
</head>
<body>
	<!-- main -->
	<div class="main agileits-w3layouts">
		<div class="main-agileinfo"> 
		
			<div class="agileui-forms">
				<div class="container-form">
					
					<div class="form-item log-in"><!-- sign-up form-->
						<div class="w3table w3-agileits">
							<div class="w3table-cell register">   
									<h3>Sign up</h3>
								<form method="POST" action="{{ route('register') }}">
								@csrf
									<div class="fields-grid">
										<div class="styled-input agile-styled-input-top">
											<input id="name" type="text" class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> 
											<label for="name">{{ __('Name') }}</label>
											@error('name')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
											<label for="email">{{ __('E-Mail Address') }}</label>
											@error('email')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="phone" type="tel" name="phone" required="">
											<label for="phone">Mobile Number</label>
											@error('phone')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="designation" type="text" name="designation" required="">
											<label for="designation">Designation</label>
											@error('designation')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="department" type="text" name="department" required="">
											<label for="department">Department</label>
											@error('department')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="city" type="text" name="city" required="">
											<label for="city">City</label>
											@error('city')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="state" type="text" name="state" required="">
											<label for="state">State</label>
											@error('state')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="country" type="text" name="country" required="">
											<label for="country">Country</label>
											@error('country')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="pin" type="text" name="pin" required="">
											<label for="pin">Pin</label>
											@error('pin')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										{{-- acc_type hidden --}}
										<input type="hidden" name="acc_type" value="user">
										{{-- //acc_type hidden --}}
										<div class="styled-input">
											<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
											<label for="password">{{ __('Password') }}</label>
											@error('password')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="styled-input">
											<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
											<label for="password-confirm">{{ __('Confirm Password') }}</label>
											@error('password')
											<div>
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
												</div>
											@enderror
										</div>
										<div class="clear"> </div>
										 <label class="checkbox"><input type="checkbox" name="checkbox" checked><i></i>I agree to the <a href="#">Terms and Conditions</a></label>
									</div>
									<input type="submit" value="Sign up">
								</form>

							</div>
						</div>
					</div>
				</div>
				<div class="container-info">
					
					<div class="info-w3lsitem">
                    <div class="w3table">
							<div class="w3table-cell">
								<p> Have an account? </p>
								<a class="btn" href="{{ route('login') }}"> Sign in </a>
							</div>
						</div>
						
					</div>
                    <div class="info-w3lsitem">
                    <!-- <div class="w3table">
							<div class="w3table-cell">
								<p> Dont have an account?</p>
								<a class="btn" href="{{ route('register') }}">Sign up</a>
							</div>
						</div> -->
						<!-- <div class="w3table">
							<div class="w3table-cell">
								<p> Have an account? </p>
								<a class="btn" href="{{ route('login') }}"> Sign in </a>
							</div>
						</div> -->
					</div>
					<div class="clear"> </div>
				</div> 
				
				
			</div> 
		</div>	
	</div>   
	<!-- //main -->
	<!-- js -->  
	<script  src=" {{ URL::asset('login_form/js/jquery-1.12.3.min.js') }}"></script> 
	<!-- <script>
		$(".info-w3lsitem .btn").click(function() {
			  $(".main-agileinfo").toggleClass("log-in");
			});
			$(".container-form .btn").click(function() {
			  $(".main-agileinfo").addClass("active");
		});
	</script> -->
	<!-- //js --> 
</body>
</html>