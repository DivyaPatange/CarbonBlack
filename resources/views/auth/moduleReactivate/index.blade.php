@extends('auth.admin_layouts.main')

@section('title', 'Module Reactivate')

@section('custom_styles')
    <style>
       .hidden{
           display:none;
       }
    .isdisabled { 
        pointer-events: none; 
        cursor: default; 
    } 
    </style>
@endsection

@section('content')

<div class="mdc-layout-grid">

</div>
<div class="mdc-layout-grid">
 @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">	
                    <strong>{{ $message }}</strong>
            </div>
            @endif
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Module Reactivate</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-left">ID</th>
                <th class="text-left">User Name</th>
                <th class="text-left">Section Name</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($tab as $t)
            <?php
              $attempt = DB::table('attempt')->where('tab_id', $t->course_id)->where('status', 0)->get();
             
            
            ?>
            @foreach($attempt as $key => $a)
            <?php
              $name = DB::table('users')->where('id', $a->user_id)->first();
              
            ?>
            <tr>
              <td class="text-left">{{ ++$key }}</td>
              <td class="text-left">{{ $name->name }}</td>
              <td class="text-left">{{ $t->name }}</td>
              <td class="text-left"><a href="{{ route('test.enabled', $a->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Enabled</a></td>
            </tr>
            @endforeach
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection