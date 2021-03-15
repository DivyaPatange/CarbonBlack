
<?php

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));
// dd($current_datetime);

$exam_start_time = $takeTest->created_at;
$duration = $test->time . ' minute';
$exam_end_time = strtotime($exam_start_time . '+' . $duration);

$exam_end_time = date('Y-m-d H:i:s', $exam_end_time);
$remaining_minutes = strtotime($exam_end_time) - time();

$exam_status = $takeTest->status;
?>
@extends('auth.admin_layouts.main')

@section('title','Test Question')

@section('customcss')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="{{ asset('brandAssets/css/TimeCircles.css') }}" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
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
.mdc-card{
	background:transparent;
}
.mdc-text-field--outlined .mdc-text-field__input{
	border:2px solid black !important;
}
.card{
	background-color:transparent;
	border-radius:1.25rem;
	border:2px solid black;
	height:300px;
	overflow-y :scroll;
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
.col{
	width:20%;
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
.active{background:green}
.inactive{background:red}
canvas{
	width:0;
	height:0;
}
.textDiv_Minutes{
	top:2px !important;
	width:50px !important;
}
.textDiv_Seconds{
	top:2px !important;
	width:50px !important;
	left:70px !important;
}
#watermark {
  /* height: 450px; */
  /* width: 600px; */
  position: relative;
  /* overflow: hidden; */
  z-index:100;
}
#watermarkText {
  position: absolute;
  top: 225px;
  left: 125px;
  color: lightgrey;
  font-size: 50px;
  opacity:0.5;
  pointer-events: none;
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  /* z-index:100; */
}
label{
	margin-bottom:0px;
}
.test-heading{
	background-color: #ffd78e;
    /* height: 34px; */
    width: 100%;
    border-radius: 18px;
    border: 2px solid black;
	padding: 0 16px;
}
.block{
	border:2px solid black;
	padding:20px;
	border-radius:14px;
}

    </style>
     <script src="http://www.codermen.com/js/jquery.js"></script>
@endsection

@section('content')
@if($exam_status == 0)
<div class="mdc-layout-grid p-0">
	<div class="mdc-layout-grid__inner">
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
			<div class="test-heading d-flex justify-content-between">
			<?php 
				$test = DB::table('test')->where('id', $takeTest->test_id)->first();
				$question = DB::table('question')->where('test_id', $test->id)->get();
				if(!empty($test))
				{
					$coursetab = DB::table('coursetabs')->where('course_id', $test->tab_id)->where('status', 1)->first();
				}
			?>
				<h6 class="mt-1"><b>Module @if(!empty($test)) @if(!empty($coursetab)) {{ $coursetab->name }} @endif @endif</b></h6>
				<h6 class="mt-1"><i class="fa fa-info-circle" aria-hidden="true">&nbsp;</i>View Instructions</h6>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8 pr-0">
		<div class="row">
			<div class="col-md-9">
				<div class="row">
					<div class="col-md-3">
						<div class="test-heading">
							<h6 class="mt-1">Section</h6>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5">
					<div class="test-heading">
					<h6 class="mt-1"><i class="fa fa-info-circle" aria-hidden="true">&nbsp;</i>Question 1 to {{ count($question) }}</h6>
				</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
			<div class="test-heading" style="height:100%">
			<h6>Time Left :</h6>
				<div id="exam_timer" class="demo" data-timer="{{ $remaining_minutes }}" height="100">
					</div>
					<p id="demo"></p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12" id="single_question_area">
				
			</div>
		</div>
	</div>
	<div class="col-md-4 pl-0">
		<div class="row">
			<div class="col-md-12">
				<div class="block">
					<img src="{{ asset('img/download.png') }}" alt="" width="100px" class="float-left">
					<h2 class="p-4">{{ Auth::user()->name }}</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="block">
					<div class="row">
						<div class="col-md-6">
							<div class="d-flex">
								<img src="{{ asset('img/download1.png') }}" width="25px" height="25px" alt="" class="m-1">
								<h6 class="m-1">Answered</h6>
							</div>
						</div>
						<div class="col-md-6">
							<div class="d-flex">
								<img src="{{ asset('img/download2.png') }}" width="25px" height="25px" alt="" class="m-1">
								<h6 class="m-1">Not Visited</h6>
							</div>
						</div>
						<div class="col-md-6">
							<div class="d-flex">
								<img src="{{ asset('img/download3.png') }}" width="25px" height="25px" alt="" class="m-1">
								<h6 class="m-1">Not Answered</h6>
							</div>
						</div>
						<div class="col-md-6">
							<div class="d-flex">
								<img src="{{ asset('img/download4.png') }}" width="25px" height="25px" alt="" class="m-1">
								<h6 class="m-1">Marked For Review</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="test-heading">
					<h6 class="mt-1">Question 1 to {{ count($question) }}</h6>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" id="question_navigation_area"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12" id="buttonArea"></div>
</div>
<!-- <div class="mdc-layout-grid">
	<div class="mdc-layout-grid__inner">
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-10 " >
		</div>
	  	<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-2 " >
	  		<div class="mdc-card" style="background-color:transparent; box-shadow:none; padding:0px">
				<div id="exam_timer" class="demo" data-timer="{{ $remaining_minutes }}" height="150">
            	</div>
            </div>
			<p id="demo"></p>
	  	</div>
	</div>
</div> -->
  <!-- <div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner mt-2">
      	<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8 " id="single_question_area">
		  
      	</div>
      	<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 " >
		  	<div class="mdc-layout-grid__inner">
				<div class="mdc-layout-grid__cell stretch-card d-block mdc-layout-grid__cell--span-12">fskgj</div>
			</div>
			<div class="mdc-layout-grid__inner">
				<div class="mdc-layout-grid__cell stretch-card d-block mdc-layout-grid__cell--span-12" id="question_navigation_area"></div>
			</div>
      	</div>
    </div>
  </div> -->
  @foreach($question as $q)
  <!-- The Modal -->
  <div class="modal fade" id="test{{ $q->id }}">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Hint</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          {{ $q->que_hint }}
        </div>
        
        
      </div>
    </div>
  </div>
  @endforeach
  @endif
<div id="costumModal17" class="modal" data-easein="slideDownIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">
					Submit Test
				</h4>
			</div>
			<div class="modal-body">
				<table class="table">
					<tr>
						<th>No. of Questions Attempted</th>
						<th>No. of Not Attempted Questions</th>
					</tr>
					<tr>
						<td class="text-left" id="attemptedQue">2</td>
						<td class="text-left" id="notAttemptQue">3</td>
					</tr>
				</table>
				<p>Do You Want to Submit Test?</p>
				<button class="submit btn-primary">
					Yes
				</button>
				<button class=" btn-danger" data-dismiss="modal" aria-hidden="true">
					No
				</button>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>
@endsection
@section('customjs')
 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('brandAssets/js/TimeCircles.js') }}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
   $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>

<script>
 document.addEventListener("keyup", function (e) {
    var keyCode = e.keyCode ? e.keyCode : e.which;
            if (keyCode == 44) {
                stopPrntScr();
            }
        });
function stopPrntScr() {

            var inpFld = document.createElement("input");
            inpFld.setAttribute("value", ".");
            inpFld.setAttribute("width", "0");
            inpFld.style.height = "0px";
            inpFld.style.width = "0px";
            inpFld.style.border = "0px";
            document.body.appendChild(inpFld);
            inpFld.select();
            document.execCommand("copy");
            inpFld.remove(inpFld);
        }
       function AccessClipboardData() {
            try {
                window.clipboardData.setData('text', "Access   Restricted");
            } catch (err) {
            }
        }
        setInterval("AccessClipboardData()", 300);
$(document).ready(function(){
  var exam_id = "{{ $test->id }}";
  var take_test_id =  "{{ $takeTest->id }}";
//   alert(que_id);
  // alert(exam_id);
	load_question();
	question_navigation();

	function load_question(question_id = '')
	{
		$.ajax({
			url:"{{ route('get.question') }}",
			method:"POST",
			data:{exam_id:exam_id,take_test_id:take_test_id, question_id:question_id, page:'testQuestion', action:'load_question'},
			success:function(data)
			{
				$('#single_question_area').html(data.output);
				$('#buttonArea').html(data.button)
			}
		})
	}
  	$(document).on('click', '.next', function(){
		var question_id = $(this).attr('id');
		
		var prev_que_id = $(this).attr('current-id');
		var take_test_id =  "{{ $takeTest->id }}";
		load_question(question_id);
		// console.log(prev_que_id);
		if(prev_que_id != "")
		{
			$.ajax({
			url:"{{ route('checkUserAnswer') }}",
			method:"POST",
			data:{prev_que_id:prev_que_id, take_test_id:take_test_id, page:'testQuestion', action:'checkAnswer'},
			success:function(data)
			{
				console.log(data.userAnswer);
				if(data.userAnswer != null)
				{
					var que_nav = $("[data-question_id^='"+data.prev_que_id+"']").css({"background-color":"#12a63a", "color":"white", "border-color":"white", "font-weight": "900", "border-radius": "50%"});
				}
				else if(data.not_ans == 1)
				{
					var que_nav = $("[data-question_id^='"+data.prev_que_id+"']").css({"background-color":"red", "color":"white", "border-color":"white", "font-weight": "900", "border-radius": "50%"});
				}
				// if(data.prev_que_id == );
				console.log(que_nav);
				// $('#question_navigation_area').html(data);
			}
			})
		}
	});

	$(document).on('click', '.review', function(){
		var question_id = $(this).attr('id');
		var que_id = $(this).attr('current-id');

		load_question(question_id);
		if(que_id != "")
		{
			$.ajax({
			url:"{{ route('markForReview') }}",
			method:"POST",
			data:{que_id:que_id, take_test_id:take_test_id, page:'testQuestion', action:'review'},
			success:function(data)
			{
				console.log(data);
				if(data.review == 1)
				{
					var que_nav = $("[data-question_id^='"+data.prev_que_id+"']").css({"background-color":"#ffc000", "color":"white", "border-color":"white", "font-weight": "900", "border-radius": "50%"});
				}
			}
			})
		}
	})

	$(document).on('click', '.clearResponse', function(){
		var que_id = $(this).attr('current-id');
		if(que_id != "")
		{
			$.ajax({
			url:"{{ route('removeAns') }}",
			method:"POST",
			data:{que_id:que_id, take_test_id:take_test_id, page:'testQuestion', action:'clearResponse'},
			success:function(data)
			{
				load_question(data.que_id);
				question_navigation();
			}
			})
		}
	})

	$(document).on('click', '.previous', function(){
		var question_id = $(this).attr('id');
		load_question(question_id);
	});

  function question_navigation()
	{
		$.ajax({
			url:"{{ route('question.navigate') }}",
			method:"POST",
			data:{take_test_id:take_test_id, exam_id:exam_id, page:'testQuestion', action:'question_navigation'},
			success:function(data)
			{
				$('#question_navigation_area').html(data);
			}
		})
	}

	$(document).on('click', '.question_navigation', function(){
		var question_id = $(this).data('question_id');
		$('.btn').removeClass('active').addClass('inactive');
		$(this).removeClass('inactive').addClass('active');
		
		load_question(question_id);
	});
  	// $('#exam_timer').TimeCircles({ 
	// 	time:{
	// 		Days:{
	// 			show: false
	// 		},
	// 		Hours:{
	// 			show: false
	// 		}
	// 	}
	// });

	// interval = setInterval(function(){
	// 	var remaining_second = $('#exam_timer').TimeCircles().getTime();
	// 	if(remaining_second < 1)
	// 	{
    //   clearInterval(interval);
    //   document.getElementById("exam_timer").innerHTML="Done";
    //   alert("You're out of time!");
    //   window.location.href="{{ route('user.test.result', ['id' => $takeTest->id]) }}";

	// 	}
	// }, 1000);

  $(document).on('click', '.answer_option', function(){
		var question_id = $(this).data('question_id');
    // alert(question_id);
		var answer_option = $(this).data('id');
    // alert(answer_option);
		$.ajax({
			url:"{{ route('user.test.store') }}",
			method:"POST",
			data:{question_id:question_id, answer_option:answer_option, exam_id:exam_id, take_test_id:take_test_id ,page:'testQuestion', action:'answer'},
			success:function(data)
			{

			}
		})
	});

	$(document).on('click', '.answer_trueorfalse', function(){
		var question_id = $(this).data('question_id');
    // alert(question_id);
		var answer_option = $(this).data('id');
    // alert(answer_option);
		$.ajax({
			url:"{{ route('user.test.trueorfalse.store') }}",
			method:"POST",
			data:{question_id:question_id, answer_option:answer_option, exam_id:exam_id, take_test_id:take_test_id ,page:'testQuestion', action:'trueorfalse'},
			success:function(data)
			{

			}
		})
	});

	$(document).on('click', '.multiple', function(){
		var question_id = $(this).data('question_id');
		// alert(question_id);
		var lang = [];
		// alert(lang);
		// Initializing array with Checkbox checked values
		$("input[name='option_2']:checked").each(function(){
			lang.push(this.value);
			// alert(lang);
		});
		// alert(question_id != '');
		if(question_id != ''){
		$.ajax({
			url: "{{ route('user.test.multiple.store') }}",
			method: "POST",
			data: {question_id:question_id, exam_id:exam_id, take_test_id:take_test_id, lang:lang ,page:'testQuestion', action:'checkbox_answer'},
			success: function(data){
			}
		});
		}
	});
	$(document).on('keyup', '.blank', function(){
		var question_id = $(this).data('question_id');
		// alert(question_id);
		var blank = $("#txt_name").val();
		// alert(blank);
		if(question_id != ''){
		$.ajax({
			url: "{{ route('user.test.blank.store') }}",
			method: "POST",
			data: {question_id:question_id, exam_id:exam_id, take_test_id:take_test_id, blank:blank ,page:'testQuestion', action:'input_answer'},
			success: function(data){
			}
		});
		}
	});

	$(document).on('click', '.submit', function(){
	
		window.location.href="{{ route('submit.test', $takeTest->id) }}";
		
	});
	

});
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script> -->
<script>
function selectOnlyThis(id){
  var myCheckbox = document.getElementsByName("myCheckbox");
  Array.prototype.forEach.call(myCheckbox,function(el){
  	el.checked = false;
  });
  id.checked = true;
}  
function selectOnlyThis1(id){
  var myCheckbox1 = document.getElementsByName("myCheckbox1");
  Array.prototype.forEach.call(myCheckbox1,function(el){
  	el.checked = false;
  });
  id.checked = true;
} 

function SubmitTest(obj,bid)
{
    var datastring="bid="+bid;
    // alert(datastring);
    $.ajax({
        type:"POST",
        url:"{{ route('admin.get.submitTestResult') }}",
        data:datastring,
        cache:false,        
        success:function(returndata)
        {
            // alert(returndata);
        if (returndata!="0") {
            $("#costumModal17").modal('show');
            var json = JSON.parse(returndata);
            $("#attemptedQue").html(json.attemptedQue);
            $("#notAttemptQue").html(json.notAttemptQue);
        }
        }
    });
}
</script>
@endsection