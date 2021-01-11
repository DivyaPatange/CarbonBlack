@extends('auth.admin_layouts.main')

@section('title','Courses')

@section('customcss')
    <style>

    </style>
@endsection

@section('content')
<div class="mdc-layout-grid">
@can('manage-users')
<a href="{{ route('coursesData.create') }}" class="mdc-button mdc-button--raised filled-button--info">
    Add Course
</a>
<!-- <a href="" class="mdc-button mdc-button--raised filled-button--info">
    View Course
</a> -->

<div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Courses List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable">
            <thead>
              <tr>
                <th class="text-left">ID</th>
                <th class="text-left">Course Name</th>
                <th class="text-left">Course Description</th>
                <th class="text-left">Course Overview</th>
                <th class="text-left">Banner Image</th>
                <th class="text-left">Cover Image</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($courses as $key => $course)
                <tr>
                  <td class="text-left">{{ ++$key }}</td>
                  <td class="text-left">{{$course->name}}</td>
                  <td class="text-left" width="40%"><p class="text-wrap">{{$course->description}}</p></td>
                  <td class="text-left" width="40%"><p class="text-wrap">{{$course->overview}}</p></td>
                  <td class="text-left" ><img src="{{ 'storage/bannerImage/'.$course->bannerImage }}" class="card-img-top" alt="..." width="50%"></td>
                  <td class="text-left" ><img src="{{ 'storage/coverImage/'.$course->coverImage }}" class="card-img-top" alt="..." width="50%"></td>
                  <td class="text-left"><a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                    <form action="{{ route('coursesData.destroy',$course->id) }}" method="post">
                    @method('DELETE')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endcan
    <div class="mdc-layout-grid__inner mt-5">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
            <div class="p-0">
                <h6 class="card-title card-padding pb-0" style="display:inline-block;">Course</h6>
                <div class="col-12 mt-4 pb-4">

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="{{$course->name}}" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{$course->name}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Course 2</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Course 3</a>
                    </li>
                </ul>
                @php
                    $explodeModule = explode(",", $course->module);
                @endphp
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="{{$course->name}}">
                        <div class="mdc-layout-grid">
                            <div class="mdc-layout-grid__inner">
                                <!-- <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12"> -->
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-12-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner mr-0">
                                                <iframe width="100%" height="315" src="{{ $explodeModule[0] }}" frameborder="0" allowfullscreen></iframe>
                                                {{-- <video width="100%" height="240" controls>
                                                    <source src="movie.mp4" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                </video> --}}
                                                <h5 class="card-title">Course 1</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-12-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner mr-0">
                                                {{-- <video width="100%" height="240" controls>
                                                    <source src="{{URL::asset('videos/carbonBlack/index.htm')}}" type="video/htm">
                                                    <source src="movie.ogg" type="video/ogg">
                                                </video> --}}
                                                <h5 class="card-title">Course 1</h5>
                                            </div>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="mdc-layout-grid">
                            <div class="mdc-layout-grid__inner">
                                <!-- <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12"> -->
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-12-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner mr-0">
                                                <video width="100%" height="240" controls>
                                                    <source src="movie.mp4" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                </video>
                                                <h5 class="card-title">Course 1</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-12-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner mr-0">
                                                <video width="100%" height="240" controls>
                                                    <source src="movie.mp4" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                </video>
                                                <h5 class="card-title">Course 1</h5>
                                            </div>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="mdc-layout-grid">
                            <div class="mdc-layout-grid__inner">
                                <!-- <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12"> -->
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-12-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner mr-0">
                                                <video width="100%" height="240" controls>
                                                    <source src="movie.mp4" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                </video>
                                                <h5 class="card-title">Course 1</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-12-tablet">
                                        <div class="mdc-card info-card info-card--success">
                                            <div class="card-inner mr-0">
                                                <video width="100%" height="240" controls>
                                                    <source src="movie.mp4" type="video/mp4">
                                                    <source src="movie.ogg" type="video/ogg">
                                                </video>
                                                <h5 class="card-title">Course 1</h5>
                                            </div>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
