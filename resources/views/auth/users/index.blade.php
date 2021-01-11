@extends('auth.admin_layouts.main')

@section('title','User')

@section('custom_styles')
    <style>
       .hidden{
           display:none;
       }
    </style>
@endsection

@section('content')

<div class="mdc-layout-grid">
    @if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong><i class="fa fa-check text-white">&nbsp;</i>{{ $message }}</strong>
</div>
@endif
@if ($message = Session::get('danger'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
</div>
@endif
@can('manage-admin-user')

<a href="{{ route('adminReg.create') }}" class="mdc-button mb-4 mdc-button--raised filled-button--info">
    Add Administrator   
</a>
@endcan
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">@if($result->acc_type == "superadmin")Administrator @else Users @endif List</h6>
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
              @foreach($users as $key => $user)
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
                              <a href="{{ route('adminReg.user.edit', ['id'=>$user->id]) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Edit</a>
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
                @endif   
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@can('manage-admin-user')
<div class="mdc-layout-grid">
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Users  List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Account Type</th>
                <th class="text-center">Date</th>
                <th class="text-center">Select Company</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($emp as $key => $user)
              <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td class="text-center">{{$user->name}}</td>
                <td class="text-center">{{$user->email}}</td>
                <td class="text-center">{{$user->acc_type}}</td>
                <td class="text-center">{{ $user->created_at }}</td>
                <td class="text-center">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf 
                @method('PUT')
                  <select class="form-control" name="company_name">
                    <option value="">- Select Company -</option>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}">{{$u->name}}</option>
                    @endforeach
                  </select>
                </td>
                <td class="text-center">
                <button type="submit" class="mdc-button mdc-button--unelevated filled-button--info mdc-ripple-upgraded">Update</button>
                </form>
                <a href="javascript:void(0)" onclick="$('#deleteForm').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                  <form id="deleteForm" action="{{ route('deleteusers',['id'=>$user->id]) }}" method="post">
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
</div>
@endcan
@endsection