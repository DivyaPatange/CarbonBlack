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
                <th class="text-center">Test Name</th>
                <th class="text-center">Total Mark</th>
                <th class="text-center">Time (in Minutes)</th>
                <!--<th class="text-center">Action</th>-->
              </tr>
            </thead>
            <tbody>
            @foreach($test as $key => $t)
            <?php
              
              $tab = DB::table('coursetabs')->where('course_id', $t->tab_id)->first();
              
            ?>
              <tr>
                <td class="text-center">{{ ++$key }}</td>
                <td class="text-center">@if(!empty($tab)) {{ $tab->name }} @endif</td>
                <td class="text-center">{{ $t->marks }}</td>
                <td class="text-center">{{ $t->time }}</td>
                <!--<td class="text-center"><a href="{{ route('question.view', $t->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--info mdc-ripple-upgraded">View Question</a></td>-->
                
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