@extends('auth.admin_layouts.main')

@section('title','Test Question')

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

<a href="{{ route('question.create', $test->id) }}" class="mdc-button mb-4 mdc-button--raised filled-button--info "  <?php if($total == $test->marks){  ?> onclick="return false" <?php } ?>>
    Add Question  
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
        <h6 class="card-title card-padding pb-0">Question List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-left">ID</th>
                <th class="text-left">Question</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach($que as $key => $q)
            <tr>
              <td class="text-left">{{ ++$key }}</td>
              <td class="text-left">{{ $q->question }}</td>
              <td class="text-left"><a href="{{ route('question.edit', $q->id) }}" type="button" class="mdc-button mdc-button--unelevated filled-button--warning mdc-ripple-upgraded">Edit</a>
                  <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="mdc-button mdc-button--unelevated filled-button--secondary mdc-ripple-upgraded">Delete</button></a>
                  <form action="{{ route('question.delete',['id'=>$q->id]) }}" method="post">
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