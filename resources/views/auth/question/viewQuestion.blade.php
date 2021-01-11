@extends('auth.admin_layouts.main')

@section('title','Test Question')

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
        <h6 class="card-title card-padding pb-0">Question  List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Question</th>
                <th class="text-center">Question Mark</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($que as $key => $q)
            <tr>
              <td class="text-center">{{ ++$key }}</td>
              <td class="text-center">{{ $q->question }}</td>
              <td class="text-center">{{ $q->que_mark }}</td>
              <td class="text-center"><a href="{{ route('company.question.view', $q->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">View Question</a>
                  
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