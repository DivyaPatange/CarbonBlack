@extends('auth.admin_layouts.main')

@section('title','User List')

@section('custom_styles')
    <style>
       .hidden{
           display:none;
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
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">{{ $users->name }} Users List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Account Type</th>
                <th class="text-center">Status</th>
                <th class="text-center">Date</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($results as $key => $user)
                  @if(Auth::user()->acc_type == 'superadmin')
                      @can('manage-admin-user')
                            @if($user->id == 1)
                            <tr style="display:none"></tr>
                            @else
                          
                            <tr>
                              <td class="text-center">{{ ++$key }}</td>
                              <td class="text-center">{{$user->name}}</td>
                              <td class="text-center">{{$user->email}}</td>
                              <td class="text-center">{{$user->acc_type}}</td>
                              <td class="text-center">@if($user->status == 0) Inactive @else Active @endif</td>
                              <td class="text-center">{{ $user->created_at }}</td>
                              <td class="text-center">
                              <a href="{{ route('status', ['id'=>$user->id]) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--info mdc-ripple-upgraded">@if($user->status == 1) Inactive @else Active @endif</a>
                              <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                                <form action="{{ route('deleteusers',['id'=>$user->id]) }}" method="post">
                                  @method('DELETE')
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                              </td>
                            </tr>
                           
                            @endif
                     @endcan
                    
                @else
                     @if($user->acc_type == 'superadmin' || $user->acc_type == 'admin')
                    
                    <tr style="display:none"></tr>
                    @else
                  
                    <tr>
                      <td class="text-center">{{ $key }}</td>
                      <td class="text-center">{{$user->name}}</td>
                      <td class="text-center">{{$user->email}}</td>
                      <td class="text-center">{{$user->acc_type}}</td>
                      <td class="text-center">@if($user->status == 0) Inactive @else Active @endif</td>
                      <td class="text-center">{{ $user->created_at }}</td>
                      <td class="text-center">
                      <a href="{{ route('status', ['id'=>$user->id]) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--info mdc-ripple-upgraded">@if($user->status == 1) Inactive @else Active @endif</a>
                      <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                        <form action="{{ route('deleteusers',['id'=>$user->id]) }}" method="post">
                          @method('DELETE')
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                      </td>
                    </tr>
                   
                    @endif
                @endif   
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @can('manage-users')
<a href="{{ route('tab.create', $users->id) }}" class="mdc-button mdc-button--raised filled-button--info mt-5">
    Add Section
</a>
<!-- <a href="" class="mdc-button mdc-button--raised filled-button--info">
    View Course
</a> -->
<div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Section List</h6>
        <div class="table-responsive p-4">
           <table class="table table-hoverable" id="datatable">
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Section Name</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($coursetab as $key => $c)
                <tr>
                  <td class="text-center">{{ ++$key }}</td>
                  <td class="text-center" width="40%"><p class="text-wrap">{{$c->name}}</p></td>
                  <td class="text-center">@if($c->status == 1) Active @else Inactive @endif</td>
                  <td class="text-center">
                  <a href="{{ route('status.tab', $c->course_id) }}"><button type="button" class="mdc-button mdc-button--unelevated filled-button--primary mdc-ripple-upgraded">@if($c->status == 1) Inactive @else Active @endif</button></a>
                      <a href="{{ route('edit.tab', $c->course_id) }}"><button type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Edit</button></a>
                    <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                            <form action="{{ route('deletetab', $c->course_id) }}" method="post">
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
<div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Modules List</h6>
        <div class="table-responsive p-4">
           <table class="table table-hoverable" id="datatable1">
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Module Title</th>
                <th class="text-center">Module Image</th>
                <th class="text-center">Module Category</th>
                <th class="text-center">Module Description</th>
                <th class="text-center">Module Folder Path</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($coursetab as $c)
            @foreach($tempcourses ?? '' as $key => $course)
            @if($c->name == $course->category)
                <tr>
                  <td class="text-center">{{ ++$key }}</td>
                  <td class="text-center">{{ $course->title }}</td>
                  <td class="text-center" ><img src="{{ URL::to('/') }}/courseImg/{{$course->img}}" class="card-img-top" alt="..." width="50%"></td>
                  <td class="text-center" width="40%"><p class="text-wrap">{{$course->category}}</p></td>
                  <td class="text-center" width="40%"><p class="">{{$course->description}}</p></td>
                  <td class="text-center" width="40%"><p class="text-wrap">{{$course->path}}</p></td>
                  <td class="text-center">
                    
                    <a href="{{ route('tempCoursesData.edit', $course->id) }}">
                        <button type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Edit</button>
                    </a>
                    <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()">
                        <button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button>
                    </a>

                    <form action="{{ route('tempCoursesData.destroy',$course->id) }}" method="post">
                        @method('DELETE')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                  </td>
                </tr>
                @endif
              @endforeach
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
                        <p class="card-body block text-center" style="word-break : break-word;">
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
        <div class="modal-body" style="word-break: break-word;">
          {{ $course->description }}
        </div>
      </div>
    </div>
  </div>
  @endforeach
 <!-- The Modal -->
</div>



   
 
@endsection