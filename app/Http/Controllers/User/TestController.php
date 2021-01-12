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

class TestController extends Controller
{
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
        $test = Test::where('user_id', $user->parent_id)->get();
        return view('auth.test.takeTest', compact('user', 'test'));
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
                            <div class="mdc-card p-0">
                            <div id="watermark">
  <img src="http://www.topchinatravel.com/pic/city/dalian/attraction/people-square-1.jpg">
  <p>This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark. This is a watermark.</p>
</div>
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$key.'. '.$que->question.
                                '</b></h6>
                                <div class="mdc-card" style="display:inline">
                                <button class="mdc-button mdc-button--outlined mdc-button--dense mdc-ripple-upgraded" style="--mdc-ripple-fg-size:44px; --mdc-ripple-fg-scale:2.06352; --mdc-ripple-fg-translate-start:32.9874px, 1.20001px; --mdc-ripple-fg-translate-end:15.0938px, -6px;" data-toggle="modal" data-target="#test'.$que->id.'">
                                    Hint
                                </button>
                                </div>
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
                            ';
                        }
                        if($que->que_type == "multiple"){
                            $ans1 = DB::table('user_answer')->where('take_test_id', $request->take_test_id)
                            ->where('test_id', $request->exam_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('question_id', $que->id)->first();
                            $output .= '
                            <div class="mdc-card p-0" id="watermark">
                            
  <p id="watermarkText">CarbonBlack Education</p>
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$key.'. '.$que->question.
                                '</b></h6>
                                <div class="mdc-card" style="display:inline">
                                <button class="mdc-button mdc-button--outlined mdc-button--dense mdc-ripple-upgraded" style="--mdc-ripple-fg-size:44px; --mdc-ripple-fg-scale:2.06352; --mdc-ripple-fg-translate-start:32.9874px, 1.20001px; --mdc-ripple-fg-translate-end:15.0938px, -6px;" data-toggle="modal" data-target="#test'.$que->id.'">
                                Hint
                            </button>
                                </div>
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
                            ';
                        }
                        if($que->que_type == "blank"){
                            $ans2 = DB::table('user_answer')->where('take_test_id', $request->take_test_id)
                            ->where('test_id', $request->exam_id)
                            ->where('user_id', Auth::user()->id)
                            ->where('question_id', $que->id)->first();
                            $output .= '
                            <div class="mdc-card p-0">
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$key.'. '.$que->question.
                                '</b></h6>
                                <div class="mdc-card" style="display:inline">
                                <button class="mdc-button mdc-button--outlined mdc-button--dense mdc-ripple-upgraded" style="--mdc-ripple-fg-size:44px; --mdc-ripple-fg-scale:2.06352; --mdc-ripple-fg-translate-start:32.9874px, 1.20001px; --mdc-ripple-fg-translate-end:15.0938px, -6px;" data-toggle="modal" data-target="#test'.$que->id.'">
                                    Hint
                                </button>
                                </div>
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
                            <div class="mdc-card p-0">
                                <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>'.$key.'. '.$que->question.
                                '</b></h6>
                                <div class="mdc-card" style="display:inline">
                                <button class="mdc-button mdc-button--outlined mdc-button--dense mdc-ripple-upgraded" style="--mdc-ripple-fg-size:44px; --mdc-ripple-fg-scale:2.06352; --mdc-ripple-fg-translate-start:32.9874px, 1.20001px; --mdc-ripple-fg-translate-end:15.0938px, -6px;" data-toggle="modal" data-target="#test'.$que->id.'">
                                    Hint
                                </button>
                                </div>
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
                        $output .= '
                    <div class="mdc-card" style="display:inline-block; text-align:center">
                      <button type="button" style="border-width:3px" class="mdc-button previous mdc-button--outlined outlined-button--secondary mdc-ripple-upgraded" name="previous" id="'.$previous_id.'" '.$if_previous_disable.'>
                        Previous
                      </button>
                      <button type="button" style="border-width:3px" class="next  mdc-button mdc-button--outlined outlined-button--warning mdc-ripple-upgraded" name="next" id="'.$next_id.'" '.$if_next_disable.'>
                        Save & Next
                      </button>
                      <button type="button" style="border-width:3px" class="submit mdc-button mdc-button--outlined outlined-button--success mdc-ripple-upgraded" name="submit">
                        Submit
                      </button>
                      </div>
                      </div>
                      ';
                    }
                    }
                    return $output;
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
                        <div class="card-header">Question Navigation</div>
                        <div class="card-body">
                            <div class="row">
                    ';
                    $count = 1;
                    foreach($exam as $row)	
                    {
                        $userAnswer = Answer::where('take_test_id', $request->take_test_id)->where('test_id', $request->exam_id)->where('question_id', $row->id)->first();
                        $output .= '
                        <div class="col-md-4 col-3" style="margin-bottom:24px;">
                            <button style="height:40px; padding: 0 10px; min-width:0px;'; if($userAnswer != null){ $output .= 'background-color:#12a63a; color:white; border-color:white; font-weight: 900; border-radius:50%;';}  $output .= '" type="button" class=" mdc-button mdc-button--outlined outlined-button--secondary mdc-ripple-upgraded question_navigation btn inactive" data-question_id="'.$row->id.'">'.sprintf("%02d", $count).'</button>
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
                    $userAnswer = Answer::where('take_test_id', $request->take_test_id)->where('question_id', $request->prev_que_id)->first();
                    return response()->json([
                        'userAnswer' => $userAnswer,
                        'prev_que_id' => $que_id,
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


}
