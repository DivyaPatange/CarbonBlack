@extends('auth.admin_layouts.main')

@section('title','Certificate')

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
<div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Test Certificate</h6>
        <div class="table-responsive p-4">
           <table class="table table-hoverable" id="datatable">
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Section Name</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($takeTest as $key => $t)
            <?php
                $ans = DB::table('user_answer')->where('take_test_id', $t->id)->sum('mark');
                $test = DB::table('test')->where('id', $t->test_id)->first();
                // dd($ans);
            ?>
            
            @if(!empty($test))
            @if($ans >= $test->passing_mark)
            <tr>
                <td class="text-center">{{ ++$key }}</td>
                <?php
                if(!empty($test)){
                $section = DB::table('coursetabs')->where('course_id', $test->tab_id)->first();
                // dd($section);
                }
                ?>
                <td class="text-center">@if(!empty($section)) {{ $section->name }} @endif</td>
                <td class="text-center"><a href="{{ route('certificate.download', $t->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--info mdc-ripple-upgraded">View</a></td>
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
    
 
 
@endsection