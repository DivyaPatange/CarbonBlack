
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
  <link rel="stylesheet" href="{{ asset('brandAssets/css/TimeCircles.css') }}" />
  
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
.active{background:green}
.inactive{background:red}

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

    </style>
     <script src="http://www.codermen.com/js/jquery.js"></script>
@endsection

@section('content')
@if($exam_status == 0)
<div class="mdc-layout-grid">
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
</div>
  <div class="mdc-layout-grid">
    <div class="mdc-layout-grid__inner mt-2">
      	<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8 " id="single_question_area">
		  
      	</div>
      	<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 " id="question_navigation_area">
      	</div>
    </div>
  </div>
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
				$('#single_question_area').html(data);
			}
		})
	}
  	$(document).on('click', '.next', function(){
		var question_id = $(this).attr('id');
		
		var prev_que_id = $(this).attr('id') - 1;
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
				// if(data.prev_que_id == );
				console.log(que_nav);
				// $('#question_navigation_area').html(data);
			}
			})
		}
	});

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
		var proceed = confirm("Are you sure you want to submit test?");
		if (proceed) {
		  //proceed
		window.location.href="{{ route('submit.test', $takeTest->id) }}";
		} else {
		}
		
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
</script>
@endsection