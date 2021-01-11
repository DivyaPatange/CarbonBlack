
@extends('auth.admin_layouts.main')

@section('title','Test Result')

@section('customcss')

<meta name="csrf-token" content="{{ csrf_token() }}">

      <style>
     .files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 0;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}

    </style>
     <script src="http://www.codermen.com/js/jquery.js"></script>
@endsection

@section('content')

<div class="mdc-layout-grid">
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Result</h6>
        <div class="table-responsive p-4">
          <table class="table">
            <thead>
              <tr>
                <th class="text-center">Total Marks</th>
                <th class="text-center">Out Of</th>
                <th class="text-center">Result</th>
              </tr>
            </thead>
            <tbody>
            <td class="text-center">{{ $result }}</td>
            <td class="text-center">{{ $test->marks }}</td>
            <td class="text-center">@if($result >= $test->passing_mark) Pass @else Fail @endif</td>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mdc-layout-grid">
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Question</h6>
        <div class="table-responsive p-4">
          <table class="table table-hoverable">
            <thead>
              <tr>
                <th class="text-left">Sr. No.</th>
                <th class="text-left">Question</th>
                <th class="text-left">Answer</th>
                <th class="text-left">Correct Answer</th>
                <th class="text-left">Status</th>
              </tr>
            </thead>
            <tbody>
            @foreach($question as $key => $que)
            <tr>
            <td class="text-left">{{ ++$key }}</td>
            <td class="text-left">{{ $que->question }}</td>
            <?php
              $correctAns = DB::table('answer')->where('question_id', $que->id)->first();
              $user_ans = DB::table('user_answer')->where('take_test_id', $takeTest->id)->where('question_id', $que->id)->where('user_id', Auth::user()->id)->first();
              // dd($user_ans);
              if(!empty($user_ans)){
              $option1 = DB::table('options')->where('question_id', $user_ans->question_id)->where('option_number', '=', $user_ans->answer_option)->first();
              // dd($option1);
              }
              if($que->que_type == "single")
              {
                $option = DB::table('options')->where('question_id', $que->id)->where('option_number', '=', $correctAns->correct_ans)->first();
                
              }
              
            ?>
            <td class="text-left">
            @if(!empty($user_ans))
            @if($que->que_type == "single") @if(!empty($option1)){{ $option1->option_title }} @endif @endif
            @if($que->que_type == "blank") {{  $user_ans->answer_option }}  @endif
            @if($que->que_type == "trueorfalse") {{  $user_ans->answer_option }}  @endif
            <?php if($que->que_type == "multiple")
            { 
              $ans2 = DB::table('user_answer')->where('question_id', $que->id)->where('take_test_id', $takeTest->id)->where('user_id', Auth::user()->id)->first();
              // dd($ans2);
              $explodeans1 = explode(",", $ans2->answer_option);
              
            }
            ?>
             @if($que->que_type == "multiple") 
            <?php
            foreach($explodeans1 as $es)
            {
              $opt1 = DB::table('options')->where('question_id', $ans2->question_id)->where('option_number', $es)->first();
              ?>
            {{ $opt1->option_title }} <br>
            <?php } ?>
              @endif
            @else
            ...
            @endif
            </td>
            <td class="text-left">@if($que->que_type == "single"){{ $option->option_title }} @endif
            @if($que->que_type == "blank") {{ $correctAns->correct_ans }} @endif
            @if($que->que_type == "trueorfalse")  {{ $correctAns->correct_ans }} @endif
            <?php if($que->que_type == "multiple")
            { 
              $ans1 = DB::table('answer')->where('question_id', $que->id)->first();
              // dd($ans1);
              $explodeans = explode(",", $ans1->correct_ans);
              
            }
            ?>
            @if($que->que_type == "multiple") 
            <?php
            foreach($explodeans as $e)
            {
              $opt = DB::table('options')->where('question_id', $ans1->question_id)->where('option_number', $e)->first();
              ?>
            {{ $opt->option_title }} <br>
            <?php } ?>
              @endif
            </td>
            <td class="text-left">@if(!empty($user_ans)) Attempted  @else Not Attempted @endif</td>
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
@section('customjs')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('brandAssets/js/TimeCircles.js') }}"></script>
<script>
   $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>

@endsection
