@extends('auth.admin_layouts.main')

@section('title','User List')

@section('customcss')
    <style>
       .hidden{
           display:none;
       }
       .disabled { 
        pointer-events: none; 
        cursor: default; 
    } 
    .card-body{
      height:200px;
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
    <!-- <div class="mdc-layout-grid__inner mt-5"> -->
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
        <div class="mdc-card p-0">
            <h4 class="card-title card-padding pb-0" style="display:inline-block;"><b>Take Test</b></h4>
            <div class="container">
                <div class="row">
                @foreach($test as $t)
                    <div class="col-md-4 mt-4 pb-4">
                        <div class="mdc-card card-hover" >
                            <div class="card-body block text-center">
                            <?php
                                $tab = DB::table('coursetabs')->where('course_id', $t->tab_id)->first();
                                // dd($tab);
                                if(!empty($tab))
                                {
                                    $tabname = $tab->name;
                                }
                                
                               
                                // dd($takeTest);
                            ?>
                            <h5 class="card-title">{{ $tabname }}</h5>
                            <p>Time:- {{ $t->time }} Min.</p>
                            <p>Total Mark:- {{ $t->marks }} </p>
                            </div>
                            <!-- <div id="count"></div> -->
                           
                              <a data-toggle="modal" data-target="#test{{ $t->id }}"  class="btn btn-primary 
                              <?php 
                              $takeTest = DB::table('take_test')->where('test_id', $t->id)->where('user_id', Auth::user()->id)->where('status', 1)->where('is_verified', 1)->get();
                              // dd($attempt);
                              if(count($takeTest) >= 3)
                              {
                                $result = DB::table('attempt')->where('test_id', $t->id)->where('user_id', Auth::user()->id)->update(['status' => 0]);
                                $attempt = DB::table('attempt')->where('test_id', $t->id)->where('user_id', Auth::user()->id)->first();
                                if($attempt->status == 0){
                                ?>
                                disabled
                                <?php
                                }
                              }
                              if(count($takeTest) <= 3)
                              {
                                foreach($takeTest as $u){
                                  
                                    if($u->result == "Pass")
                                    {
                                      $result = DB::table('attempt')->where('test_id', $t->id)->where('user_id', Auth::user()->id)->update(['status' => 0]);
                                      $attempt = DB::table('attempt')->where('test_id', $t->id)->where('user_id', Auth::user()->id)->first();
                                      // dd($attempt->status == 0);
                                      if($attempt->status == 0){
                                      ?>
                                      disabled
                                      <?php
                                    }
                                  }
                                } 
                               } ?>">Start Test</a>
                            <!-- <div id="count">Start</div> -->
                           
                           
                           
                        
                        </div> 
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
 </div>
 <!-- Modal -->
 @foreach($test as $t)
 <div class="modal" id="test{{ $t->id }}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <?php
                                $tab = DB::table('coursetabs')->where('course_id', $t->tab_id)->first();
                                $question = DB::table('question')->where('test_id', $t->id)->get();
                                // dd($question);
                                // dd($tab);
                                if(!empty($tab))
                                {
                                    $tabname = $tab->name;
                                }
                            ?>
        <!-- Modal Header -->
        <form action="{{ route('view.question', $t->id) }}" method="post">
        @csrf
        <div class="modal-header">
       
          <h4>Instructions for Test</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-justify">
        <p>This begins an examination (test) for the course CARBON BLACK TECHNOLOGY “SECTION :
          {{ $tabname }}”.</p>
        <p><b>PLEASE READ THESE INSTRUCTIONS CAREFULLY. IF YOU DO NOT UNDERSTAND
THE INSTRUCTIONS, PLEASE CONTACT THE HUMAN RESOURCES.</b></p>
        <ol>
          <li>The section has <b>{{ count($question) }}</b> questions, with a total of <b>{{ $t->marks }} Marks</b>.</li>
          <li>Each question is based on information presented in the video modules that you have just completed.
Please answer each question on the basis of the content given in the modules. In some instances,
more than one option may seem to answer the question. In such a case, please choose the option that
most accurately and comprehensively answers the question.</li>
<li>Click on <b>✓</b> box to select the answer</li>
<li>Click on the <span style="background-color: #337ab7; color:white;"><</span> <span style="background-color: #337ab7; color:white;">></span> button to move on to the next set of questions.</li>
<li>Once you have answered the section to your satisfaction, you can click on <span style="background-color: #337ab7; color:white;">Submit</span> to finalize the
complete test. You will then be directed to a table to review your results on each question and the
score for the total examination.
</li>
<li>You MUST submit answers to all the examination questions (in this case, <b>{{ count($question) }}</b> questions).  Any question not answered will be scored zero (0)..

</li>
<li>To pass the exam you need to score {{ ($t->passing_mark/$t->marks)*100 }}% (i.e {{ $t->passing_mark }} marks)</li>
<li>A timer will begin when you click on <b>START TEST</b> and you will be given {{ $t->time }} minutes to complete the exam.  If you do not complete the examination in {{ $t->time }} minutes (by clicking on Submit), a FAIL grade for the test will be recorded.
</li>
<li>You will be given three chances to pass this examination.  
</li>
<li>After each FAILED examination attempt, you will be given the opportunity to review the material in the respective modules again before you attempt another examination.</li>
<li>After three failed attempts you will be blocked from continuing to review modules in this SECTION and will have to register for this course again with approval from the appropriate department head and the program administrator from Human Resources.</li>
 <li>The timer will begin when the <b>START TEST</b> button is clicked.</li>
 <li>If you are ready, PLEASE CLICK the <b>START TEST</b> button now to begin the examination. </li>
        </ol>
        </div>  
        <!-- Modal footer -->
        <div class="modal-footer">
        <button class="mdc-button mdc-button--raised filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:26.15px, 3.80002px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit">
                      Start Test
                    </button>
                    <button type="button" class="mdc-button mdc-button--raised filled-button--secondary mdc-ripple-upgraded" data-dismiss="modal">
                      Cancel
                    </button>
          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
        </div>
        </form>
      </div>
    </div>
  </div>
@endforeach
 <!-- /End Modal -->
@endsection
@section('customjs')
<script>
var count = 10;
var interval = setInterval(function(){
  document.getElementById('count').innerHTML=count;
  count--;
  if (count === 0){
    clearInterval(interval);
    document.getElementById('count').innerHTML='Done';
    location.reload();
    // or...
    // alert("You're out of time!");
  }
}, 1000);
</script>
@endsection