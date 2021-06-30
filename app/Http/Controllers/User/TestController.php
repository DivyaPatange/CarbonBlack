<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Admin\Test;
use App\Admin\Question;
use App\Admin\Answer;
use App\Admin\TakeTest;
use App\Admin\Attempt;
use DB;
use PDF;
use Mail;
use App\Admin\UserCourse;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $id = Auth::user()->id;
        // dd($id);
        $test = Test::where('user_id', $id)->get();
        return view('auth.test.viewTest', compact('test'));
    }

    public function viewQuestion($id)
    {
        $que = Question::where('test_id', $id)->get();
        return view('auth.question.viewQuestion', compact('que'));
    }
    public function takeTest()
    {
        
        $user = User::findorfail(Auth::user()->id);
        // dd($user);
        $getCourse = UserCourse::where('user_id', Auth::user()->id)->first();
        $explodeCourse = explode(",", $getCourse->user_course_id);
        // $test = DB::table('test')->where('user_id', $user->parent_id)->join('coursetabs', 'coursetabs.course_id', '=', 'test.tab_id')->get();
        // dd($test);
        return view('auth.test.takeTest', compact('user', 'explodeCourse'));
    }

    public function testQuestion(Request $request, $id)
    {
        $test = Test::findorfail($id);
        $takeTest = new TakeTest();
        $takeTest->user_id = Auth::user()->id;
        $takeTest->test_id = $test->id;
        $takeTest->save();

        $attempt = Attempt::where('user_id', Auth::user()->id)->where('test_id', $test->id)
                    ->where('tab_id', $test->tab_id)->first();
        if(empty($attempt))
        {
            $attempt = new Attempt();
            $attempt->user_id = Auth::user()->id;
            $attempt->test_id = $test->id;
            $attempt->tab_id = $test->tab_id;
            $attempt->status = 1;
            $attempt->save();
        }
        return redirect()->route('get.take.test', $takeTest->id);
    }
    public function getTestView($id)
    {
        $takeTest = TakeTest::findorfail($id);
        $test = Test::where('id', $takeTest->test_id)->first();
        $question = Question::where('test_id', $test->id)->get();
        // dd($question);
        return view('auth.question.testQuestion', compact('test', 'takeTest', 'question'));
    }

    public function getTestQuestion(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                // dd($request->action == 'load_question');
                if($request->action == 'load_question')
                {
                    $examNumber = DB::table('question')->where('test_id', $request->exam_id)->orderBy('id', 'ASC')->get();
                    $items = array();
                    foreach($examNumber as $e)
                    {
                        $items[] = $e;
                    }
                    // dd($items);
                    // dd($request->question_id == '');
                    if($request->question_id == '')
                    {
                        $exam = DB::table('question')->where('test_id', $request->exam_id)->orderBy('id', 'ASC')->limit(1)->get();
                        // dd($exam);
                    }
                    else
                    {
                        $exam = DB::table('question')->where('id', $request->question_id)->get();
                        // dd($exam);
                    }
                    $output = '';
                    $button = '';
                    // $key = 1;
                    foreach($exam as $que)
                    {
                        if(in_array($que, $items) == $que){
                            // dd(array_search($que, $items));
                        $key = array_search($que, $items)+1;
                        if($que->que_type == "single"){
                            $ans = DB::table('user_answer')->where('take_test_id', $request->take_test_id)
                            ->where('test_id', $request->exam_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('question_id', $que->id)->first();
                            // dd($ans);
                            $output .= '
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="test-heading">
                                        <h6><b>Question Type : MCQ</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-5">
                                    <div class="test-heading">
                                        <h6><b>Marks For Correct Answer: '.$que->que_mark.'</b></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <h6 class="mt-1"><b>Question No. '.$key.'</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <a data-toggle="modal" data-target="#test'.$que->id.'">
                                            <h6 class="mt-1"><i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b> Hint</b></h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mdc-card p-0" style="border:2px solid black; border-radius:11px; min-height:457.5px">
                                    <div id="watermark">
                            <p id="watermarkText">carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education </p>
                                        <p id="watermarkText">carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education</p>
                                        <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$que->question.'</b></h6>
                                        <div class="mdc-card">
                                            <div class="template-demo">
                                                <div class="mdc-layout-grid__inner">';
                                                    $option = DB::table('options')->where('question_id', $que->id)->get();
                                                    $count = 1;
                                                    foreach($option as $sub_row)
                                                    {
                                        $output .= '<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                        <div class="mdc-form-field">
                                                            <div class="mdc-checkbox mdc-checkbox--success">';
                                                            if(!empty($ans))
                                                            {
                                                                if($ans->answer_option == $count){
                                                                $output .= '<input type="checkbox" name="myCheckbox" class="answer_option mdc-checkbox__native-control" data-question_id="'.$que->id.'" data-id="'.$count.'" onclick="selectOnlyThis(this)" checked>';
                                                                }
                                                                else{
                                                                $output .= '<input type="checkbox" name="myCheckbox" class="answer_option mdc-checkbox__native-control" data-question_id="'.$que->id.'" onclick="selectOnlyThis(this)" data-id="'.$count.'">';
                                                                }
                                                            }
                                                            else{
                                                                $output .= '<input type="checkbox" name="myCheckbox" class="answer_option mdc-checkbox__native-control" data-question_id="'.$que->id.'" onclick="selectOnlyThis(this)" data-id="'.$count.'">';
                                                            }
                                                    
                                                            $output .= '<div class="mdc-checkbox__background">
                                                                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                                                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                                            </svg>
                                                                            <div class="mdc-checkbox__mixedmark"></div>
                                                                        </div>
                                                            </div>
                                                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">'.$sub_row->option_title.'</label>
                                                        </div>
                                                    </div>';
                                                    $count = $count + 1;
                                                    }
                                                $output .= '
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        if($que->que_type == "multiple"){
                            $ans1 = DB::table('user_answer')->where('take_test_id', $request->take_test_id)
                            ->where('test_id', $request->exam_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('question_id', $que->id)->first();
                            $output .= '
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="test-heading">
                                        <h6><b>Question Type : MCQ</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-5">
                                    <div class="test-heading">
                                        <h6><b>Marks For Correct Answer: '.$que->que_mark.'</b></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <h6 class="mt-1"><b>Question No. '.$key.'</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <a data-toggle="modal" data-target="#test'.$que->id.'">
                                            <h6 class="mt-1"><i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp; <b>Hint</b></h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mdc-card p-0"  style="border:2px solid black; border-radius:11px; min-height:457.5px">
                            <div id="watermark">
                            <p id="watermarkText">carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education </p>
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$que->question.
                                '</b></h6>
                                <div class="mdc-card" >
                                    <div class="template-demo">
                                        <div class="mdc-layout-grid__inner">';
                                            $option = DB::table('options')->where('question_id', $que->id)->get();
                                            $count = 1;
                                            foreach($option as $sub_row)
                                            {
                                            $output .= '
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                    <div class="mdc-form-field">
                                                        <div class="mdc-checkbox mdc-checkbox--info">';
                                                        if(!empty($ans1))
                                                        {
                                                            $answer = explode(",", $ans1->answer_option);
                                                            if(in_array( $count ,  $answer) == $count)
                                                            {
                                                            $output .= '<input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control multiple" name="option_2" data-question_id="'.$que->id.'" value="'.$count.'" checked>';
                                                            }
                                                            else{
                                                                $output .= '<input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control multiple" name="option_2" data-question_id="'.$que->id.'" value="'.$count.'">';  
                                                            }
                                                        }
                                                        else{
                                                            $output .= '<input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control multiple" name="option_2" data-question_id="'.$que->id.'" value="'.$count.'">';  
                                                        }
                                                        $output .= '<div class="mdc-checkbox__background">
                                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                                </svg>
                                                                <div class="mdc-checkbox__mixedmark"></div>
                                                            </div>
                                                        </div>
                                                        <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">'.$sub_row->option_title.'</label>
                                                    </div>
                                                </div>
                                            </div>';
                                                $count = $count + 1;
                                            }
                                            $output .= '
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            ';
                        }
                        if($que->que_type == "blank"){
                            $ans2 = DB::table('user_answer')->where('take_test_id', $request->take_test_id)
                            ->where('test_id', $request->exam_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('question_id', $que->id)->first();
                            $output .= '
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="test-heading">
                                        <h6><b>Question Type : MCQ</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-5">
                                    <div class="test-heading">
                                        <h6><b>Marks For Correct Answer: '.$que->que_mark.'</b></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <h6 class="mt-1"><b>Question No. '.$key.'</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <a data-toggle="modal" data-target="#test'.$que->id.'">
                                            <h6 class="mt-1"><i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b> Hint</b></h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mdc-card p-0"  style="border:2px solid black; border-radius:11px; min-height:457.5px">
                            <div id="watermark">
                            <p id="watermarkText">carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education </p>
                           
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$que->question.
                                '</b></h6>
                                <div class="mdc-card">
                                    <div class="template-demo">
                                        <div class="mdc-layout-grid__inner">
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                                Enter Answer
                                                </div>
                                            </div>
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">';
                                                if(!empty($ans2))
                                                {
                                                    $output .= ' <input class="blank mdc-text-field__input" id="txt_name" value="'.$ans2->answer_option.'" data-question_id="'.$que->id.'">';
                                                }
                                                else{
                                                    $output .= ' <input class="blank mdc-text-field__input" id="txt_name" data-question_id="'.$que->id.'">';
                                                }
                                                $output .= '  <div class="mdc-notched-outline">
                                                        <div class="mdc-notched-outline__leading"></div>
                                                        <div class="mdc-notched-outline__notch">
                                                        </div>
                                                        <div class="mdc-notched-outline__trailing"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            ';
                        }
                        if($que->que_type == "trueorfalse")
                        {
                            $ans3 = DB::table('user_answer')->where('take_test_id', $request->take_test_id)
                            ->where('test_id', $request->exam_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('question_id', $que->id)->first();
                            // dd($ans3);
                            $output .= '
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="test-heading">
                                        <h6> <b>Question Type : MCQ</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-5">
                                    <div class="test-heading">
                                        <h6><b>Marks For Correct Answer: '.$que->que_mark.'</b></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="test-heading">
                                        <h6 class="mt-1"><b>Question No. '.$key.'</b></h6>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="test-heading">
                                    <a data-toggle="modal" data-target="#test'.$que->id.'">
                                        <h6 class="mt-1"><i class="fa fa-info" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<b> Hint</b></h6>
                                    </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mdc-card p-0" style="border:2px solid black; border-radius:11px; min-height:457.5px">
                            <div id="watermark">
                            <p id="watermarkText">carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education carbonblack.education </p>
                            
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$que->question.
                                '</b></h6>
                                <div class="mdc-card">
                                    <div class="template-demo">
                                        <div class="mdc-layout-grid__inner">
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-form-field">
                                                    <div class="mdc-checkbox mdc-checkbox--success">';
                                                    // dd($ans3->correct_ans == "true");
                                                    if(!empty($ans3))
                                                    {
                                                        if($ans3->answer_option == "true")
                                                        {
                                                        $output .= '<input type="checkbox" name="myCheckbox1" class="mdc-checkbox__native-control answer_trueorfalse" onclick="selectOnlyThis1(this)" data-question_id="'.$que->id.'" data-id="true" checked>';
                                                        }
                                                        else{
                                                            $output .= '<input type="checkbox" name="myCheckbox1" class="mdc-checkbox__native-control answer_trueorfalse" onclick="selectOnlyThis1(this)" data-question_id="'.$que->id.'" data-id="true">';
                                                        }
                                                    }
                                                    else{
                                                        $output .= '<input type="checkbox" name="myCheckbox1" class="mdc-checkbox__native-control answer_trueorfalse" onclick="selectOnlyThis1(this)" data-question_id="'.$que->id.'" data-id="true">';
                                                    }
                                                       $output .= '<div class="mdc-checkbox__background">
                                                       <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                           <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                       </svg>
                                                       <div class="mdc-checkbox__mixedmark"></div>
                                                       </div>
                                                       </div>
                                                    <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">True</label>
                                                </div>
                                            </div>
                                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                <div class="mdc-form-field">
                                                    <div class="mdc-checkbox mdc-checkbox--success">';
                                                    if(!empty($ans3))
                                                    {
                                                        if($ans3->answer_option == "false")
                                                        {
                                                        $output .= '<input type="checkbox" name="myCheckbox1" class="mdc-checkbox__native-control answer_trueorfalse" onclick="selectOnlyThis1(this)" data-question_id="'.$que->id.'" data-id="false" checked>';
                                                        }
                                                        else{
                                                            $output .= '<input type="checkbox" name="myCheckbox1" class="mdc-checkbox__native-control answer_trueorfalse" onclick="selectOnlyThis1(this)" data-question_id="'.$que->id.'" data-id="false">';
                                                        }
                                                    }
                                                    else{
                                                        $output .= '<input type="checkbox" name="myCheckbox1" class="mdc-checkbox__native-control answer_trueorfalse" onclick="selectOnlyThis1(this)" data-question_id="'.$que->id.'" data-id="false" >';
                                                    }
                                                      $output .=  '<div class="mdc-checkbox__background">
                                                      <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                          <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                      </svg>
                                                      <div class="mdc-checkbox__mixedmark"></div>
                                                      </div>
                                                      </div>
                                                    <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">False</label>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                        $exam = DB::table('question')->where('id', '<', $que->id)->where('test_id', $request->exam_id)->orderBy('id', 'DESC')->limit(1)->get();
                        // dd($exam);
                        $previous_result = $exam;
                        $previous_id = '';
                        $next_id = '';
                        foreach($previous_result as $previous_row)
                        {
                            $previous_id = $previous_row->id;
                            // dd($previous_id);
                        }
                        $exam = DB::table('question')->where('id', '>', $que->id)->where('test_id', $request->exam_id)->orderBy('id', 'ASC')->limit(1)->get();
                        // dd($exam);
                        $next_result = $exam;
                        foreach($next_result as $next_row)
                        {
                            $next_id = $next_row->id;
                            // dd($next_id);
                        }

                        $if_previous_disable = '';
                        $if_next_disable = '';

                        if($previous_id == "")
                        {
                            $if_previous_disable = 'disabled';
                        }
                        
                        if($next_id == "")
                        {
                            $if_next_disable = 'disabled';
                        }
                        $button .= '
                        
                    <div class="mdc-card" style="display:inline-block; text-align:center; width:100%; padding:0">
                        <div class="row">
                        <div class="col-md-3 pr-0">
                    <button class="col review mdc-button mdc-button--raised mdc-ripple-upgraded" style="border-radius: 11px;
    border: 2px solid black; background-color:transparent; color:black; font-style:italic" current-id="'.$que->id.'" id="'.$next_id.'" >
                      Mark For Review & Next
                    </button>
                    </div>
                    <div class="col-md-3 p-0">
                    <button class="col clearResponse mdc-button mdc-button--raised mdc-ripple-upgraded" style="border-radius: 11px;
    border: 2px solid black; background-color:transparent; color:black;font-style:italic" current-id="'.$que->id.'">
                      Clear Response
                    </button>
                     </div>
                     <div class="col-md-3 p-0">
                      <button type="button" style="border:2px solid black; border-radius:11px;font-style:italic" class="col next  mdc-button mdc-button--raised filled-button--success mdc-ripple-upgraded" name="next" current-id="'.$que->id.'" id="'.$next_id.'" '.$if_next_disable.'>
                        Save & Next
                      </button>
                      </div>
                      <div class="col-md-3 pl-0">
                      <button type="button" style="border:2px solid black; background-color:#0070c0; border-radius:11px;font-style:italic" class="col mdc-button mdc-button--raised mdc-ripple-upgraded" name="submit" onclick="SubmitTest(this, '.$request->take_test_id.')">
                        Submit
                      </button>
                      </div>
                      </div>
                      </div>
                      </div>
                      ';
                    }
                    }
                    return response()->json(['output' => $output, 'button' => $button]);
                }
            }
        }
    }

    public function questionNavigate(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
              
                if($request->action == 'question_navigation')
                {
                    $exam = DB::table('question')->where('test_id', $request->exam_id)->orderBy('id', 'ASC')->get();
                    $output = '
                    <div class="card w-100">
                        <div class="card-header">Choose a Question</div>
                        <div class="card-body">
                            <div class="row">
                    ';
                    $count = 1;
                    foreach($exam as $row)  
                    {
                        $userAnswer = Answer::where('take_test_id', $request->take_test_id)->where('test_id', $request->exam_id)->where('user_id', Auth::user()->id)->where('question_id', $row->id)->first();
                        // dd($userAnswer);
                        $output .= '
                        <div class="col-md-4 col-3" style="margin-bottom:24px;">
                            <button style="height:40px; padding: 0 10px; min-width:0px; border-radius: 50%;
    color: black;
    border: 2px solid #4f6da1;'; 
                            if(!empty($userAnswer)){  
                                if($userAnswer->answer_option != null){ 
                                    $output .= 'background-color:#12a63a; color:white; border-color:white; font-weight: 900; border-radius:50%;';
                                } 
                                elseif($userAnswer->review == 1){ 
                                    $output .= 'background-color:#ffc000; color:white; border-color:white; font-weight: 900; border-radius:50%;';
                                } 
                                elseif($userAnswer->not_ans == 1){ 
                                    $output .= 'background-color:red; color:white; border-color:white; font-weight: 900; border-radius:50%;';
                                } 
                            } $output .= '" type="button" class=" mdc-button mdc-button--outlined outlined-button--secondary mdc-ripple-upgraded question_navigation btn inactive" data-question_id="'.$row->id.'">'.sprintf("%02d", $count).'</button>
                        </div>
                        ';
                        $count++;
                    }
                    $output .= '
                        </div>
                    </div></div>
                    ';
                    echo $output;
                }
            }
        }
    }

    public function checkUserAnswer(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'checkAnswer')
                {
                    $que_id = $request->prev_que_id;
                    // dd($que_id);
                    $userAnswer1 = Answer::where('take_test_id', $request->take_test_id)->where('user_id', Auth::user()->id)->where('question_id', $request->prev_que_id)->first();
                    $takeTest = DB::table('take_test')->where('id', $request->take_test_id)->first();
                    // dd($userAnswer1);
                    if(!empty($userAnswer1))
                    {
                        $row = Answer::where('take_test_id', $request->take_test_id)->where('user_id', Auth::user()->id)->where('question_id', $request->prev_que_id)->update(['not_ans' => 1]);
                    }
                    else{
                        $result = new Answer();
                        $result->take_test_id = $request->take_test_id;
                        $result->test_id = $takeTest->test_id;
                        $result->user_id = Auth::user()->id;
                        $result->question_id = $que_id;
                        $result->not_ans = 1;
                        $result->save();
                    }
                    $userAnswer = Answer::where('take_test_id', $request->take_test_id)->where('user_id', Auth::user()->id)->where('question_id', $request->prev_que_id)->first();
                    return response()->json([
                        'userAnswer' => $userAnswer->answer_option,
                        'prev_que_id' => $que_id,
                        'not_ans' => $userAnswer->not_ans,
                    ]);
                }
            }
        }
        // return isset($request->page);
    }

    public function testResultStore(Request $request)
    {
        // dd(isset($request->page));
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'answer')
                {
                    $test = DB::table('test')->where('id', $request->exam_id)->first();
                    // dd($test);
                    $exam_passing_mark = $test->passing_mark;
                    // dd($exam_passing_mark);
                    $question = DB::table('question')->where('test_id', $request->exam_id)->where('id', $request->question_id)->first();
                    $ans = DB::table('answer')->where('question_id', $request->question_id)->first();
                    $question_answer_mark = $question->que_mark;
                    $correctOption = $ans->correct_ans;
                    
                    $user = DB::table('user_answer')
                    ->where('user_id', Auth::user()->id)
                    ->where('test_id', $request->exam_id)
                    ->where('question_id', $request->question_id)
                    ->where('take_test_id', $request->take_test_id)
                    ->first();
                    if($question->que_type == "single")
                    {
                        if($request->answer_option == $correctOption)
                        {
                            $mark = $question_answer_mark;
                        }
                        else{
                            $mark = 0;
                        }
                        if(empty($user))
                        {
                            $user = new Answer();
                            $user->take_test_id = $request->take_test_id;
                            $user->user_id = Auth::user()->id;
                            $user->test_id = $request->exam_id;
                            $user->question_id = $request->question_id;
                            $user->answer_option = $request->answer_option;
                            $user->mark = $mark;
                            $user->save();
                        }
                        else{
                            $user = DB::table('user_answer')
                            ->where('user_id', Auth::user()->id)
                            ->where('test_id', $request->exam_id)
                            ->where('question_id', $request->question_id)
                            ->where('take_test_id', $request->take_test_id)
                            ->update([
                                'answer_option' => $request->answer_option,
                                'mark' => $mark,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function storeCheckboxAnswer(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'checkbox_answer')
                {
                    $test = DB::table('test')->where('id', $request->exam_id)->first();
                    $question = DB::table('question')->where('test_id', $request->exam_id)->where('id', $request->question_id)->first();
                    $ans = DB::table('answer')->where('question_id', $request->question_id)->first();
                    $question_answer_mark = $question->que_mark;
                    $correctOption = $ans->correct_ans;
                    $user = DB::table('user_answer')
                    ->where('user_id', Auth::user()->id)
                    ->where('test_id', $request->exam_id)
                    ->where('question_id', $request->question_id)
                    ->where('take_test_id', $request->take_test_id)
                    ->first();
                    if($question->que_type == "multiple")
                    {
                        $lang = $request->lang;
                        $foundjquery = "Not found";
                        if(in_array('jQuery',$lang)){
                            $foundjquery = "found";
                        }
                        // Converting the array to comma separated string
                        $lang = implode(",",$lang);
                        if($lang == $correctOption)
                        {
                            $mark = $question_answer_mark;
                        }
                        else{
                            $mark = 0;
                        }
                        if(empty($user))
                        {
                            $user = new Answer();
                            $user->take_test_id = $request->take_test_id;
                            $user->user_id = Auth::user()->id;
                            $user->test_id = $request->exam_id;
                            $user->question_id = $request->question_id;
                            $user->answer_option = $lang;
                            $user->mark = $mark;
                            $user->save();
                        }
                        else{
                            $user = DB::table('user_answer')
                            ->where('user_id', Auth::user()->id)
                            ->where('test_id', $request->exam_id)
                            ->where('question_id', $request->question_id)
                            ->where('take_test_id', $request->take_test_id)
                            ->update([
                                'answer_option' => $lang,
                                'mark' => $mark,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function storeInputAnswer(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'input_answer')
                {
                    $test = DB::table('test')->where('id', $request->exam_id)->first();
                    $question = DB::table('question')->where('test_id', $request->exam_id)->where('id', $request->question_id)->first();
                    $ans = DB::table('answer')->where('question_id', $request->question_id)->first();
                    $question_answer_mark = $question->que_mark;
                    $correctOption = $ans->correct_ans;
                    $user = DB::table('user_answer')
                    ->where('user_id', Auth::user()->id)
                    ->where('test_id', $request->exam_id)
                    ->where('question_id', $request->question_id)
                    ->where('take_test_id', $request->take_test_id)
                    ->first();
                    if($question->que_type == "blank")
                    {
                        $blank = $request->blank;
                        if($blank == $correctOption)
                        {
                            $mark = $question_answer_mark;
                        }
                        else{
                            $mark = 0;
                        }
                        if(empty($user))
                        {
                            $user = new Answer();
                            $user->take_test_id = $request->take_test_id;
                            $user->user_id = Auth::user()->id;
                            $user->test_id = $request->exam_id;
                            $user->question_id = $request->question_id;
                            $user->answer_option = $blank;
                            $user->mark = $mark;
                            $user->save();
                        }
                        else{
                            $user = DB::table('user_answer')
                            ->where('user_id', Auth::user()->id)
                            ->where('test_id', $request->exam_id)
                            ->where('question_id', $request->question_id)
                            ->where('take_test_id', $request->take_test_id)
                            ->update([
                                'answer_option' => $blank,
                                'mark' => $mark,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function storeTrueOrFalseAnswer(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'trueorfalse')
                {
                    $test = DB::table('test')->where('id', $request->exam_id)->first();
                    $question = DB::table('question')->where('test_id', $request->exam_id)->where('id', $request->question_id)->first();
                    $ans = DB::table('answer')->where('question_id', $request->question_id)->first();
                    $question_answer_mark = $question->que_mark;
                    $correctOption = $ans->correct_ans;
                    $user = DB::table('user_answer')
                    ->where('user_id', Auth::user()->id)
                    ->where('test_id', $request->exam_id)
                    ->where('question_id', $request->question_id)
                    ->where('take_test_id', $request->take_test_id)
                    ->first();
                    if($question->que_type == "trueorfalse")
                    {
                        $true = $request->answer_option;
                        if($true == $correctOption)
                        {
                            $mark = $question_answer_mark;
                        }
                        else{
                            $mark = 0;
                        }
                        if(empty($user))
                        {
                            $user = new Answer();
                            $user->take_test_id = $request->take_test_id;
                            $user->user_id = Auth::user()->id;
                            $user->test_id = $request->exam_id;
                            $user->question_id = $request->question_id;
                            $user->answer_option = $true;
                            $user->mark = $mark;
                            $user->save();
                        }
                        else{
                            $user = DB::table('user_answer')
                            ->where('user_id', Auth::user()->id)
                            ->where('test_id', $request->exam_id)
                            ->where('question_id', $request->question_id)
                            ->where('take_test_id', $request->take_test_id)
                            ->update([
                                'answer_option' => $true,
                                'mark' => $mark,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function getTestResult($id)
    {
        $takeTest = TakeTest::findorfail($id);
        $test = Test::where('id', $takeTest->test_id)->first();
        $question = Question::where('test_id', $takeTest->test_id)->get();
        $ans = Answer::where('take_test_id', $id)->get()->sum('mark');
        $current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));
        // dd($current_datetime);

        $exam_start_time = $takeTest->created_at;
        $duration = $test->time . ' minute';
        $exam_end_time = strtotime($exam_start_time . '+' . $duration);

        $exam_end_time = date('Y-m-d H:i:s', $exam_end_time);
        $remaining_minutes = strtotime($exam_end_time) - time();


        if($current_datetime > $exam_end_time)
        {
            if($ans >= $test->passing_mark)
            {
                $take_test = DB::table('take_test')
                ->where('id', $takeTest->id)
                ->update(['status'=> 1, 'result' => "Pass", 'is_verified' => 1]);
                $takeTest1 = DB::table('take_test')->where('id', $id)->first();
                // dd($takeTest);
                $user = DB::table('users')->where('id', $takeTest1->user_id)->first();
                $data["email"] = $user->email;
                $data["title"] = "Test Certificate";
                $data["body"] = "You have successfully passed the test. Please find attachment of certificate below.";
                $folderPath = public_path('certificate/');
                $takeTestArray = (array)$takeTest1;
                // dd($takeTestArray);
                $pdf = PDF::loadView('auth.mailCertificate', $takeTestArray)->setPaper('a4', 'landscape');
                $fileName = uniqid() . '.pdf';
        
                $file = $folderPath . $fileName;
                $path = file_put_contents($file, $pdf->output());
                // dd($file);
                $pdfFile = public_path('certificate/'.$fileName);
                Mail::send('email.myTestMail', $data, function($message)use($data, $pdfFile) {
                    $message->to($data["email"], $data["email"])
                            ->subject($data["title"])
                            ->attach($pdfFile);
                    
                });
            }
            else{
                $take_test = DB::table('take_test')
                ->where('id', $takeTest->id)
                ->update(['status'=> 1, 'result' => "Fail", 'is_verified' => 1]);
            }
        }
        $userAnswer = Answer::where('take_test_id', $takeTest->id)->get();
        // dd($userAnswer);
        $result = Answer::where('take_test_id', $takeTest->id)->get()->sum('mark');
        return view('auth.test.result', compact('takeTest', 'test', 'userAnswer', 'result', 'question'));
    }
    
    public function downloadCertificate($id)
    {
        $takeTest1 = DB::table('take_test')->where('id', $id)->first();
        $takeTestArray = (array)$takeTest1;
        $pdf = PDF::loadView('auth.mailCertificate', $takeTestArray)->setPaper('a4', 'landscape');
        return $pdf->download('certificate.pdf');
    }

    public function testResultSubmit($id)
    {
        $takeTest = TakeTest::findorfail($id);
        // dd($takeTest);
        $question = Question::where('test_id', $takeTest->test_id)->get();
        $test = Test::where('id', $takeTest->test_id)->first();
        $ans = Answer::where('take_test_id', $id)->get()->sum('mark');
        // dd($test);
        if($ans >= $test->passing_mark)
            {
                $take_test = DB::table('take_test')
                ->where('id', $takeTest->id)
                ->update(['status'=> 1, 'result' => "Pass", 'is_verified' => 1]);
                $takeTest1 = DB::table('take_test')->where('id', $id)->first();
                // dd($takeTest);
                $user = DB::table('users')->where('id', $takeTest1->user_id)->first();
                $data["email"] = $user->email;
                $data["title"] = "Test Certificate";
                $data["body"] = "You have successfully passed the test. Please find attachment of certificate below.";
                $folderPath = public_path('certificate/');
                $takeTestArray = (array)$takeTest1;
                // dd($takeTestArray);
                $pdf = PDF::loadView('auth.mailCertificate', $takeTestArray)->setPaper('a4', 'landscape');
                // $pdf->setPaper('A4', 'landscape');
                $fileName = uniqid() . '.pdf';
        
                $file = $folderPath . $fileName;
                $path = file_put_contents($file, $pdf->output());
                // dd($file);
                $pdfFile = public_path('certificate/'.$fileName);
                Mail::send('email.myTestMail', $data, function($message)use($data, $pdfFile) {
                    $message->to($data["email"], $data["email"])
                            ->subject($data["title"])
                            ->attach($pdfFile);
                    
                });
            }
            else{
                $take_test = DB::table('take_test')
                ->where('id', $takeTest->id)
                ->update(['status'=> 1, 'result' => "Fail", 'is_verified' => 1]);
            }
            $userAnswer = Answer::where('take_test_id', $takeTest->id)->get();
            // dd($userAnswer);
            $result = Answer::where('take_test_id', $takeTest->id)->get()->sum('mark');
           return view('auth.test.result', compact('takeTest', 'test', 'userAnswer', 'result', 'question'));
    }
    
    public function submitTestResult(Request $request)
    {
        $takeTest = TakeTest::where('id', $request->bid)->first();
        $totalQue = Question::where('test_id', $takeTest->test_id)->get();
        $userAns = Answer::where('take_test_id', $takeTest->id)->where('test_id', $takeTest->test_id)->where('user_id', Auth::user()->id)->where('answer_option', '!=', null)->get();
        $notAttemptQue = count($totalQue) - count($userAns);
        $attemptedQue = count($userAns);
        if(isset($notAttemptQue) && isset($attemptedQue))
        {
            $data = array('notAttemptQue' =>$notAttemptQue,'attemptedQue' =>$attemptedQue
            );
        }
        else{
            $data =0;
        }
        echo json_encode($data);
    }
    
    public function markForReview(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'review')
                {
                    $que_id = $request->que_id;
                    $takeTest = DB::table('take_test')->where('id', $request->take_test_id)->first();
                    $userAns = Answer::where('take_test_id', $takeTest->id)->where('user_id', Auth::user()->id)->where('test_id', $takeTest->test_id)->where('question_id', $que_id)->first();
                    if(!empty($userAns))
                    {
                        $userAns1 = Answer::where('take_test_id', $takeTest->id)->where('user_id', Auth::user()->id)->where('test_id', $takeTest->test_id)->where('question_id', $que_id)->update(['review' => 1]);
                    }
                    else{
                        $result = new Answer();
                        $result->take_test_id = $request->take_test_id;
                        $result->test_id = $takeTest->test_id;
                        $result->user_id = Auth::user()->id;
                        $result->question_id = $que_id;
                        $result->review = 1;
                        $result->save();
                    }
                    $row = Answer::where('take_test_id', $takeTest->id)->where('user_id', Auth::user()->id)->where('test_id', $takeTest->test_id)->where('question_id', $que_id)->first();
                    return response()->json([
                        'review' => $row->review,
                        'prev_que_id' => $que_id,
                    ]);
                }
            }
        }   
    }

    public function removeAns(Request $request)
    {
        if(isset($request->page))
        {
            // dd($request->page == 'testQuestion');
            if($request->page == 'testQuestion')
            {
                if($request->action == 'clearResponse')
                {
                    $que_id = $request->que_id;
                    $takeTest = DB::table('take_test')->where('id', $request->take_test_id)->first();
                    $userAns = Answer::where('take_test_id', $takeTest->id)->where('user_id', Auth::user()->id)->where('test_id', $takeTest->test_id)->where('question_id', $que_id)->first();
                    if(!empty($userAns))
                    {
                        $userAns = Answer::where('take_test_id', $takeTest->id)->where('user_id', Auth::user()->id)->where('test_id', $takeTest->test_id)->where('question_id', $que_id)->update(['answer_option' => null, 'mark' => null, 'review' => 0, 'not_ans' => 0]);
                        return response()->json([
                            'que_id' => $que_id,
                        ]);
                    }
                }
            }
        }
    }


}
