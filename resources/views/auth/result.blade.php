@extends('auth.admin_layouts.main')

@section('title','Test Result')

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
    <a type="button" id="btnExport" onclick="Export()" class="mdc-button mb-4 mdc-button--raised filled-button--info">
     Export
</a>
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Test Result List</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable" id="datatable" >
            <thead>
              <tr>
                <th class="text-left">ID</th>
                <th class="text-left">Employee ID</th>
                <th class="text-left">User ID</th>
                <th class="text-left">Name</th>
                <th class="text-left">Result</th>
              </tr>
            </thead>
            <tbody>
            @can('manage-admin-user')
            @foreach($student as $key => $s)
            <?php
                // $name = DB::table('users')->where('id', $t->user_id)->first();
                // $test = DB::table('test')->where('id', $t->test_id)->first();
                // if(!empty($test)){
                // $section = DB::table('coursetabs')->where('course_id', $test->tab_id)->first();
                // }
                // $newtime = strtotime($t->created_at);
                // $t->time = date('M d, Y',$newtime);
                // $ans = DB::table('user_answer')->where('take_test_id', $t->id)->sum('mark');
                // dd($test);
            ?>
            <tr>
                <td class="text-left">{{ ++$key }}</td>
                <td class="text-left">{{ $s->employee_id }}</td>
                <td class="text-left">{{ $s->registration_code }}</td>
                <td class="text-left">{{ $s->name }}</td>
                <td class="text-left">
                  <a href="{{ route('view.result', $s->id) }}"><button class="mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                      View
                    </button></a>
                </td>
            </tr>
            @endforeach
            @endcan
            @can('admin')
            @foreach($student as $key => $s)
            <?php
                // $users = DB::table('users')->where('id', $v->user_id)->first();
                // $test1 = DB::table('test')->where('id', $v->test_id)->first();
                // // dd($test1);
                // if(!empty($test1)){
                // $section1 = DB::table('coursetabs')->where('course_id', $test1->tab_id)->first();
                // }
                // $newtime1 = strtotime($v->created_at);
                // $v->time = date('M d, Y',$newtime1);
                // $ans1 = DB::table('user_answer')->where('take_test_id', $v->id)->sum('mark');
            ?>
            <tr>
                <td class="text-left">{{ ++$key }}</td>
                <td class="text-left">{{ $s->employee_id }}</td>
                <td class="text-left">{{ $s->registration_code }}</td>
                <td class="text-left">{{ $s->name }}</td>
                <td class="text-left">
                  <a href="{{ route('view.result', $s->id) }}"><button class="mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                    View</button>
                  </a>
                </td>
            </tr>
            @endforeach
            @endcan
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
    
</div>



   
 
@endsection
@section('customjs')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        function Export() {
            html2canvas(document.getElementById('datatable'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("result.pdf");
                }
            });
        }
    </script>
@endsection