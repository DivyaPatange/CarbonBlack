<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Test;
use App\Admin\Question;
use App\Admin\Option;
use App\Admin\QuestionAnswer;
use Redirect;

class QuestionController extends Controller
{
    public function getQuestionType(Request $request, $id)
    {
        $test = Test::findorfail($id);
        // dd($test);
        if($request->question_type == 'single')
        {
            return view('auth.question.single', compact('test'));
        }
        if($request->question_type == "multiple")
        {
            return view('auth.question.multiple', compact('test'));
        }
        if($request->question_type == "blank")
        {
            return view('auth.question.blank', compact('test'));
        }
        if($request->question_type == "trueorfalse")
        {
            return view('auth.question.trueorfalse', compact('test'));
        }
    
    }


    public function questionSingleSubmit(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'que_hint' => 'required',
            'que_type' => 'required',
            'que_mark' => 'required', 
            'option_1' => 'required',
            'option_2' => 'required', 
            'option_3' => 'required',
            'option_4' => 'required',
            'correct_ans' => 'required'
            ]);
        $test = Test::findorfail($id);
        // dd($test);
        $exam = new Question();
        $exam->test_id = $test->id;
        $exam->question = $request->question;
        $exam->que_type = $request->que_type;
        $exam->que_mark = $request->que_mark;
        $exam->que_hint = $request->que_hint;
        $exam->save();
        for($count = 1; $count <= 4; $count++)
		{
            $option = new Option();
            $option->question_id = $exam->id;
            $option->option_number = $count;
            $option->option_title = $request['option_' . $count];
            // dd($option->option_title);
            $option->save();
        }
        $ans = new QuestionAnswer();
        $ans->question_id =$exam->id;
        $ans->correct_ans = $request->correct_ans;
        $ans->save();
        return redirect()->route('question.index', $test->id)->with('success', 'Question Added Successfully!');

    }

    public function questionMultipleSubmit(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'que_type' => 'required',
            'que_mark' => 'required', 
            'option_1' => 'required',
            'option_2' => 'required', 
            'option_3' => 'required',
            'option_4' => 'required',
            'correct_ans' => 'required',
            'que_hint' => 'required',
            ]);
        $test = Test::findorfail($id);
        $exam = new Question();
        $exam->test_id = $test->id;
        $exam->question = $request->question;
        $exam->que_type = $request->que_type;
        $exam->que_mark = $request->que_mark;
        $exam->save();
        for($count = 1; $count <= 4; $count++)
		{
            $option = new Option();
            $option->question_id = $exam->id;
            $option->option_number = $count;
            $option->option_title = $request['option_' . $count];
            // dd($option->option_title);
            $option->save();
        }
        $ans = new QuestionAnswer();
        $ans->question_id =$exam->id;
        $ans->correct_ans = implode(",", $request['correct_ans']);
        $ans->save();
        return redirect()->route('question.index', $test->id)->with('success', 'Question Added Successfully!');
    }

    public function questionBlankSubmit(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'que_type' => 'required',
            'que_mark' => 'required', 
            'correct_ans' => 'required',
            'que_hint' => 'required',
            ]);
        $test = Test::findorfail($id);
        $exam = new Question();
        $exam->test_id = $test->id;
        $exam->question = $request->question;
        $exam->que_type = $request->que_type;
        $exam->que_mark = $request->que_mark;
        $exam->que_hint = $request->que_hint;
        $exam->save();
        $ans = new QuestionAnswer();
        $ans->question_id = $exam->id;
        $ans->correct_ans = $request->correct_ans;
        $ans->save();
        return redirect()->route('question.index', $test->id)->with('success', 'Question Added Successfully!');
    }

    public function questionTrueOrFalseSubmit(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'que_type' => 'required',
            'que_mark' => 'required', 
            'correct_ans' => 'required',
            'que_hint' => 'required',
        ]);
        $test = Test::findorfail($id);
        // dd($test);
        $exam = new Question();
        $exam->test_id = $test->id;
        $exam->question = $request->question;
        $exam->que_type = $request->que_type;
        $exam->que_mark = $request->que_mark;
        $exam->que_hint = $request->que_hint;
        $exam->save();
        $ans = new QuestionAnswer();
        $ans->question_id =$exam->id;
        $ans->correct_ans = $request->correct_ans;
        $ans->save();
        return redirect()->route('question.index', $test->id)->with('success', 'Question Added Successfully!');$test = Test::findorfail($id);
        
    }

    public function editQuestion($id)
    {
        $que = Question::findorfail($id);
        $option = Option::where('question_id', $que->id)->get();
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        // dd($ans);
        if($que->que_type == "single")
        {
            // dd($option);
            return view('auth.question.editSingle', compact('que', 'option', 'ans'));
        }
        if($que->que_type == "multiple")
        {
            return view('auth.question.editMultiple', compact('que', 'option', 'ans'));
        }
        if($que->que_type == "blank")
        {
            return view('auth.question.editBlank', compact('que', 'ans'));
        }
        if($que->que_type == "trueorfalse")
        {
            return view('auth.question.editTrueorfalse', compact('que', 'ans'));
        }
    }

    public function updateSingleQuestion(Request $request, $id)
    {
        $que = Question::findorfail($id);
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        $que->question = $request->question;
        $que->que_mark = $request->que_mark;
        $que->que_hint = $request->que_hint;
        $que->update($request->all());
        // dd($que);

        for($count = 1; $count <= 4; $count++)
		{
            $option = Option::where('question_id', $que->id)->where('option_number', $count)->first();
            $option->option_number = $count;
            $option->option_title = $request['option_' . $count];
            // dd($option->option_title);
            $option->update($request->all());
        }
        $ans->correct_ans = $request->correct_ans;
        $ans->update($request->all());
        return redirect()->route('question.index', $que->test_id)->with('success', 'Question Updated Successfully!');
    }

    public function updateMultipleQuestion(Request $request, $id)
    {
        $que = Question::findorfail($id);
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        $que->question = $request->question;
        $que->que_mark = $request->que_mark;
        $que->que_hint = $request->que_hint;
        $que->update($request->all());
        // dd($que);

        for($count = 1; $count <= 4; $count++)
		{
            $option = Option::where('question_id', $que->id)->where('option_number', $count)->first();
            $option->option_number = $count;
            $option->option_title = $request['option_' . $count];
            // dd($option->option_title);
            $option->update($request->all());
        }
        // dd(implode(",", $request['correct_ans']));
        $ans->correct_ans = implode(",", $request['correct_ans']);
        // dd($ans->correct_ans);
        $ans->save();
        return redirect()->route('question.index', $que->test_id)->with('success', 'Question Updated Successfully!');
    }

    public function updateBlankQuestion(Request $request, $id)
    {
        $que = Question::findorfail($id);
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        $que->question = $request->question;
        $que->que_mark = $request->que_mark;
        $que->que_hint = $request->que_hint;
        $que->update($request->all());
        
        $ans->correct_ans = $request->correct_ans;
        $ans->update($request->all());
        return redirect()->route('question.index', $que->test_id)->with('success', 'Question Updated Successfully!');   
    }

    public function updateTrueOrFalseQuestion(Request $request, $id)
    {
        $que = Question::findorfail($id);
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        $que->question = $request->question;
        $que->que_mark = $request->que_mark;
        $que->que_hint = $request->que_hint;
        $que->update($request->all());
        
        $ans->correct_ans = $request->option_1;
        $ans->update($request->all());
        return redirect()->route('question.index', $que->test_id)->with('success', 'Question Updated Successfully!'); 
    }

    public function destroyQuestion($id)
    {
        $que = Question::findorfail($id);
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        $que->delete();
        if(!empty($ans)){
        $ans->delete();
        }
        for($count = 1; $count <= 4; $count++)
		{
            $option = Option::where('question_id', $que->id)->where('option_number', $count)->first();
            if(!empty($option)){
            $option->delete();
            }
        }
        return redirect()->route('question.index', $que->test_id)->with('success', 'Question Deleted Successfully!');
    }
}
