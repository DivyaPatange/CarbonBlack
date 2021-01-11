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
   <!-- End Clients Section -->
      <!-- courses -->
      <section id="portfolio" class="portfolio section-bg">
        <div class="container-fluid">

        <div class="section-title">
          <h2 data-aos="fade-in">Selection Of Courses On Carbon Black Technology</h2>
          <!--<p data-aos="fade-in">Choose from 40+ online video courses with new additions published</p>-->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="bs-example">
                        <ul class="nav nav-tabs">
                             @foreach($coursetab as $key => $course)
                             @php
                                $tabname = "$course->name";
                                $tabname = str_replace(' ', '', $tabname);
                             @endphp
                            <li class="nav-item">
                                <a href="#tab{{ $course->course_id }}" class="nav-link {{ $key==0 ? 'active' : ''}}" data-toggle="tab">{{ $course->name }}</a>
                            </li>
                            @endforeach
                            
                        </ul>
                        <div class="tab-content">
                            @foreach($coursetab as $key => $courses)
                            @php
                                $tabname = "$courses->name";
                                $tabname = str_replace(' ', '', $tabname);
                             @endphp
                            <div class="tab-pane fade show {{ $key==0 ? 'active' : ''}} " id="tab{{ $courses->course_id }}">
                                <div class="page-content page-container" id="page-content">
                                    <div class="p-md-4 p-sm-0">
                                        <div class="row container-fluid">
                                            <div class="col-lg-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="owl-carousel">
                                                            @foreach($tempcourses as $course)
                                                            @if($courses->name == $course->category)
                                                            <div class="item text-center"> <img src="{{ URL::to('/') }}/courseImg/{{$course->img}}" width="100%" alt="image" /> 
                                                                <div class="card-body block text-center">
                                                                
                                                                <h5 class="card-title">{{$course->title}}</h5>
                                                                
                                                                </div>
                                                                <!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">-->
                                                                <!--    Read More&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i></i>-->
                                                                <!--</button>-->
                                                                <div class="card-body pt-0 pb-0" style="height:85px">
                                                                <h6>
                                                                    @if(strlen($course->description) > 70)
                                                                    {{substr($course->description,0,70)}}....
                                                                    <br><a class="read-more-show hide_content" data-toggle="modal" data-target="#dec{{ $course->id }}" style="color:#ec5a56;">&nbsp;Read More</a>
                                                                    
                                                                    @else
                                                                    {{ $course->description }}
                                                                    @endif</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                <a href="{{ route('login') }}" target="_blank" class="btn btn-primary">Start Module</a>
                                                                </div>
                                                                
                                                            </div>
                                                            @endif
                                                            @endforeach
   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                        
                        
                    </div>
            </div>
        </div>
        

      </div>
    </section>                                                   
    <!-- The Modal -->
    @foreach($tempcourses as $course)
  <div class="modal mt-5 pt-5 " id="dec{{ $course->id }}">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      
        <div class="modal-header">
          <h4 class="modal-title">{{ $course->title }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
          {{ $course->description }}
        </div>
        
        
      </div>
    </div>
  </div>
  @endforeach
 
   
      <!-- //courses -->
      
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
</script>

@endsection