@extends('auth.admin_layouts.main')

@section('title','User Manual')

@section('custom_styles')
    <style>
       .hidden{
           display:none;
       }
    </style>
    <!-- <script src="https://use.fontawesome.com/d5c7b56460.js"></script> -->
@endsection

@section('content')
<div class="mdc-layout-grid">
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">	
        <strong>{{ $message }}</strong>
</div>
@endif
</div>
<div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner">
        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
            <div class="mdc-card p-0">
                <h6 class="card-title card-padding pb-0">Add User Manual</h6>
                <form action="{{ route('user-manual.store') }}" enctype="multipart/form-data" method="post">
                    <div class="mdc-card">
                    @csrf
                        <div class="template-demo">
                            <div class="mdc-layout-grid__inner">
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                    <input class="mdc-text-field__input" type="file"  name="file" id="file">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label class="mdc-floating-label">File</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                    <select class="mdc-text-field__input"  name="user_type" id="user_type">
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                    </select>
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label class="mdc-floating-label">User Type</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop">
                                    <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                                        Add Manual
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="mdc-layout-grid">
 
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">User Manual  List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-left">ID</th>
                <th class="text-left">File</th>
                <th class="text-left">User Type</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($manuals as $key => $m)
              <tr>
                <td class="text-left">{{ ++$key }}</td>
                <td class="text-left"><a href="{{ URL::to('/') }}/UserManual/{{$m->file}}"><i class="fa fa-file" style="font-size:30px" aria-hidden="true"></i></a></td>
                <td class="text-left">{{ $m->manual_for }}</td>
                <td class="text-left"><a href="{{ route('user-manual.edit', $m->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Edit</a>
                  <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                  <form action="{{ route('user-manual.destroy', $m->id) }}" method="post">
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
@endsection