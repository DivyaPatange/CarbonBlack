@extends('auth.admin_layouts.main')

@section('title','Test')

@section('custom_styles')
    <style>
       .hidden{
           display:none;
       }
    </style>
@endsection

@section('content')

<div class="mdc-layout-grid">

<a href="{{ route('test.create') }}" class="mdc-button mb-4 mdc-button--raised filled-button--info">
    Add Test  
</a>
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
        <h6 class="card-title card-padding pb-0">Test  List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Company Name</th>
                <th class="text-center">Section Name</th>
                <th class="text-center">Marks</th>
                <th class="text-center">Time</th>
                <th class="text-center">Passing Mark</th>
                <th class="text-center">Manage Question</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($test as $key => $t)
            <?php
              $company = DB::table('users')->where('id', $t->user_id)->first();
              if(!empty($company))
              {
                $company_name = $company->name;
              }
              $tab = DB::table('coursetabs')->where('course_id', $t->tab_id)->first();
            ?>
              <tr>
                <td class="text-left">{{ ++$key }}</td>
                <td class="text-left">{{ $company_name }}</td>
                <td class="text-left">@if(!empty($tab)) {{ $tab->name }} @endif</td>
                <td class="text-center">{{ $t->marks }}</td>
                <td class="text-center">{{ $t->time }}</td>
                <td class="text-center">{{ $t->passing_mark }}</td>
                <td><a href="{{ route('question.index', $t->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--info mdc-ripple-upgraded">View Question</a></td>
                <td><a href="{{ route('test.edit', $t->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Edit</a>
                  <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                  <form action="{{ route('test.delete',['id'=>$t->id]) }}" method="post">
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