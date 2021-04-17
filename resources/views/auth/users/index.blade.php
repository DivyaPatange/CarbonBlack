@extends('auth.admin_layouts.main')

@section('title','User')

@section('customcss')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://use.fontawesome.com/d5c7b56460.js"></script>
<style>
.hidden{
  display:none;
}
td.details-control:before {
  font-family: 'FontAwesome';
  content: '\f105';
  display: block;
  text-align: center;
  font-size: 20px;
}
tr.shown td.details-control:before{
  font-family: 'FontAwesome';
  content: '\f107';
  display: block;
  text-align: center;
  font-size: 20px;
}
.table tbody tr td{
  text-align:center;
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
          <table class="table table-hoverable" id="datatable1" >
            <thead>
              <tr>
                <th class="text-center"></th>
                <th class="text-center">Employee ID</th>
                <th class="text-center">Designation</th>
                <th class="text-center">Work Experience</th>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Account Type</th>
                <th class="text-center">Date</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endcan
@endsection
@section('customjs')
<script>
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
var SITEURL = '{{ route('users')}}';
function format ( d ) {
  // `d` is the original data object for the row
  return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width:100%">'+
      '<tr>'+
          '<td style="text-align:center">Sub Category</td>'+
          '<td style="text-align:center">'+d.company+'</td>'+
      '</tr>'+
      '<tr>'+
          '<td style="text-align:center">Action</td>'+
          '<td style="text-align:center">'+d.action+'</td>'+
      '</tr>'+
  '</table>';
}
$(document).ready(function() {
    var table = $('#datatable1').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    },
    columns: [
            { 
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { data: 'employee_id', name: 'employee_id' },
            { data: 'designation', name: 'designation' },
            { data: 'work_experience', name: 'work_experience' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'acc_type', name: 'acc_type' },
            { data: 'created_at', name: 'created_at' },
        ],
    order: [[0, 'desc']]
    });
    $('#datatable1 tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});
$('body').on('click', '#delete', function () {
    var id = $(this).data("id");

    if(confirm("Are You sure want to delete !")){
        $.ajax({
            type: "delete",
            url: "{{ url('/user/destroy/ajax') }}"+'/'+id,
            success: function (data) {
            var oTable = $('#datatable1').dataTable(); 
            oTable.fnDraw(false);
            toastr.success(data.success);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
});
$('body').on('click', '#update', function () {
    var id = $(this).data("id");
    var company_name = $('.company_name'+id).val();
    if(company_name == "")
    {
      $('.company_name'+id).focus();
      return false;
    }
    else{
      $.ajax({
        url: "{{ url('/admin/users/update') }}"+'/'+id,
        method: "PUT",
        data: {company_name:company_name},
        success: function(data){
          var oTable = $('#datatable1').dataTable(); 
            oTable.fnDraw(false);
            toastr.success(data.success);
        },
            error: function (data) {
                console.log('Error:', data);
            }
      })
    }
})
</script>
@endsection