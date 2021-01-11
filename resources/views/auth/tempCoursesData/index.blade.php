@extends('auth.admin_layouts.main')

@section('title','Courses')

@section('customcss')
    <style>
        .card-hover:hover
        {
            box-shadow: 0px 0px 15px 0px grey;
        }
    </style>
@endsection

@section('content')
<div class="mdc-layout-grid">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
  @endif
  @if(Auth::user()->acc_type == 'admin')
  <div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h4 class="card-title card-padding pb-0" style="display:inline-block;"><b>Courses</b></h4>
        <div class="container">
          <div class="bs-example">
            <ul class="nav nav-tabs">
              @foreach($coursetab as $key => $c)
              @php
                $tabname = "$c->name";
                $tabname = str_replace(' ', '', $tabname);
              @endphp
              <li class="nav-item">
                  <a href="#tab{{ $c->course_id }}" class="nav-link {{ $key==0 ? 'active' : ''}}" data-toggle="tab">{{ $c->name }}</a>
              </li>
              @endforeach
            </ul>
            <div class="tab-content">
              @foreach($coursetab as $key => $courses)
              @php
                  $tabname = "$courses->name";
                  $tabname = str_replace(' ', '', $tabname);
                  
                @endphp
                
              <div class="tab-pane fade show {{ $key==0 ? 'active' : ''}}" id="tab{{ $courses->course_id }}">
                <div class="container">
                  <div class="row">
                    @foreach($tempcourses as $course)
                    @if($courses->name == $course->category)
                    <div class="col-md-4 mt-4 pb-4">
                      <div class="mdc-card card-hover pl-0  pr-0"  style="height:520px;">
                        <img class="card-img-top" src="{{ URL::to('/') }}/courseImg/{{$course->img}}" alt="Card image cap">
                        <div class="card-body block text-center">
                          <h5 class="card-title">{{$course->title}}</h5>
                        </div>
                        <p class="card-body block text-center">
                          @if(strlen($course->description) > 60)
                          {{substr($course->description,0,60   )}}...
                          <br><a class="read-more-show hide_content" data-toggle="modal" data-target="#dec{{ $course->id }}" style="color:#ec5a56;">&nbsp;Read More</a>
                            @else
                            {{ $course->description }}
                          @endif
                        </p>
                        <div class="card-body text-center">
                        <a href="{{ URL::asset('/' . $course->path) }}" target="_blank" class="btn btn-primary">Start Module</a>
                        </div>
                      </div> 
                    </div>
                    @endif
                    @endforeach
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
@else
<div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h4 class="card-title card-padding pb-0" style="display:inline-block;"><b>Courses</b></h4>
        <div class="container">
          <div class="bs-example">
            <ul class="nav nav-tabs">
              @foreach($courses as $key => $c)
              @php
                $tabname = "$c->name";
                $tabname = str_replace(' ', '', $tabname);
              @endphp
              <li class="nav-item">
                  <a href="#tab{{ $c->course_id }}" class="nav-link {{ $key==0 ? 'active' : ''}}" data-toggle="tab">{{ $c->name }}</a>
              </li>
              @endforeach
            </ul>
            <div class="tab-content">
              @foreach($courses as $key => $co)
              @php
                  $tabname = "$co->name";
                  $tabname = str_replace(' ', '', $tabname);
                @endphp
              <div class="tab-pane fade show {{ $key==0 ? 'active' : ''}}" id="tab{{ $co->course_id }}">
                <div class="container">
                  <div class="row">
                    @foreach($tempCourses as $course)
                    @if($co->name == $course->category)
                    <?php
                  $test = DB::table('test')->where('tab_id', $co->course_id)->first();
                  // dd($test);
                  if(!empty($test)){
                  $takeTest = DB::table('take_test')->where('test_id', $test->id)->where('user_id', Auth::user()->id)->where('status', 1)->where('is_verified', 1)->get();

                  // dd($takeTest);
                  }
                ?>
                    <div class="col-md-4 mt-4 pb-4">
                      <div class="mdc-card card-hover"  style="height:520px;">
                        <img class="card-img-top" src="{{ URL::to('/') }}/courseImg/{{$course->img}}" alt="Card image cap">
                        <div class="card-body block text-center">
                          <h5 class="card-title">{{$course->title}}</h5>
                        </div>
                        <p class="card-body block text-center">
                          @if(strlen($course->description) > 60)
                          {{substr($course->description,0,60)}}...
                          <br><a class="read-more-show hide_content" data-toggle="modal" data-target="#dec{{ $course->id }}" style="color:#ec5a56;">&nbsp;Read More</a>
                          @else
                          {{ $course->description }}
                          @endif
                        </p>
                        <a href="{{$course->path}}" target="_blank" class="btn btn-primary
                        <?php 
                        if(!empty($test)){
                              if(count($takeTest) >= 3)
                              {
                                $attempt = DB::table('attempt')->where('test_id', $test->id)->where('user_id', Auth::user()->id)->first();
                                      // dd($attempt->status == 0);
                                      if($attempt->status == 0){
                                ?>
                                disabled
                                <?php
                                      }
                              }
                              if(count($takeTest) <= 3)
                              {
                                foreach($takeTest as $u){
                                  
                                    if($u->result == "Pass")
                                    {
                                      $attempt = DB::table('attempt')->where('test_id', $test->id)->where('user_id', Auth::user()->id)->first();
                                      // dd($attempt->status == 0);
                                      if($attempt->status == 0){
                                      ?>
                                      disabled
                                      <?php
                                      }
                                    }
                                } 
                               }
                               } ?>
                        ">Start Module</a>
                      </div> 
                    </div>
                    @endif
                    @endforeach
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 <!-- The Modal -->
  @foreach($tempCourses as $course)
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

@endif
      
    
    
@endsection

