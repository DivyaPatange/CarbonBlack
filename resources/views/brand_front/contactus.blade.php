@extends('brand_front.front_layouts.main')
@section('title')
@section('customcss')
<link href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" rel="stylesheet" />
    <style>
        .card-hover:hover
        {
            box-shadow: 0px 0px 15px 0px grey;
        }
        .nav-link{
            padding: .5rem 0.4rem;
        }
        /*.nav-menu .drop-down ul {*/
        /*    margin-top:15px;*/
        /*}*/
        .btn-modal{
            color: white;
            background-color: #ec5a56;
            border-color: #ec5a56;
        }
    .stretch-card>.card {
     width: 100%;
     min-width: 100%
 }
 .block{
     height:120px;
 }
 
small{
    font-size:70%;
}


 body {
     background-color: #f9f9fa
 }

 .flex {
     -webkit-box-flex: 1;
     -ms-flex: 1 1 auto;
     flex: 1 1 auto
 }


/*Owl Carousel Area*/
.owl-carousel .item {
     margin: 3px
 }

 .owl-carousel .item img {
     display: block;
     width: 100%;
     height: auto
 }

 .owl-carousel .item {
     margin: 3px
 }

 .owl-carousel {
     margin-bottom: 15px
 }
/*Owl carousel area end*/
input[type="email"]{
        font-family:sans-serif !important;
    }
    input::placeholder{
         font-family:BNKGOTHL !important;
    }
 
 
    </style>
@endsection
@section('content')
    <!--carosel section start-->
    @include('brand_front.front_layouts.banner')
    <!--carosel section ends-->
    <!-- courses -->
    <section id="portfolio" class="portfolio section-bg">
        <div class="container">
            <div class="section-title">
                <h2 data-aos="fade-in">Contact Us</h2>
                <!--<p data-aos="fade-in">Choose from 40+ online video courses with new additions published</p>-->
            </div>
            <div class="row">
                <div class="col-md-8 m-auto">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">	
                        <strong>{{ $message }}</strong>
                </div>
                @endif
                {!! NoCaptcha::renderJs() !!}
                @if($errors->has('g-recaptcha-response'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
                <form action="{{ route('store.contact') }}" method="post" id="contactForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label><span>*</span>
                                <input type="text" name="first_name"  class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}"> 
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label><span>*</span>
                                <input type="text" name="last_name"  class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label><span>*</span>
                                <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"> 
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label><span>*</span>
                                <input type="number" name="phone_no" class="form-control @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}">
                                @error('phone_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country</label><span>*</span>
                                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}">
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company</label><span>*</span>
                                <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}">
                                @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Industry</label><span>*</span>
                                <input type="text" name="industry" class="form-control @error('industry') is-invalid @enderror" value="{{ old('industry') }}"> 
                                @error('industry')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Inquiry Category</label><span>*</span>
                                <input type="text" name="inquiry_category"  class="form-control @error('inquiry_category') is-invalid @enderror" value="{{ old('inquiry_category') }}">
                                @error('inquiry_category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <small>Are you an existing client?</small>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="existing_client" value="1" @if(old('existing_client') == 1) checked="checked" @endif><small>Yes</small>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="existing_client" value="0" @if(old('existing_client') == 0) checked="checked" @endif><small>No</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <small>How can we help you?</small>
                            <textarea name="message" id="" class="form-control @error('message') is-invalid @enderror" >{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="m-auto w-50">
                             {!! NoCaptcha::display() !!}
                             </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="button" class="btn btn-secondary m-3" onclick="resetForm();">Clear</button>
                            <button type="submit" name="submit" class="btn btn-primary m-3">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
   </section>
      
<!-- director manager codirector start  section end -->
@endsection
@section('customjs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
 <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script type="text/javascript">
 $(document).ready(function() {
	$(".owl-carousel").owlCarousel({

autoPlay: 3000,
items : 4,
itemsDesktop : [1199,3],
itemsDesktopSmall : [979,3],
center: true,
nav:true,
loop:true,
responsive: {
600: {
items: 4
}
}
});
});
function resetForm() {
    document.getElementById("contactForm").reset();
}
</script>

@endsection