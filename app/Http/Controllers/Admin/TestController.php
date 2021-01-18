<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Test;
use App\Admin\Question;
use App\Admin\Option;
use App\Admin\QuestionAnswer;
use App\User;
use App\Admin\TakeTest;
use App\Coursetab;
use DB;
use Redirect;
use Auth;

class TestController extends Controller
{
    public function index()
    {
        $test = Test::all();
        return view('auth.test.index', compact('test'));
    } 

    public function create()
    {
        $company = User::where('parent_id', 1)->get();
        return view('auth.test.create', compact('company'));
    }

    public function getTabList($id)
    {
        $tabs = DB::table('coursetabs')
        ->where("admin_id",$id)->get();
        // dd($tabs);
        return json_encode($tabs);
        // dd($tabs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'section' => 'required',
            'marks' => 'required', 
            'time' => 'required',
            'passing_mark' => 'required',
        ]);
        $test =  new Test();
        $test->user_id = $request->company_name;
        $test->tab_id = $request->section;
        $test->marks = $request->marks;
        $test->time = $request->time;
        $test->passing_mark = $request->passing_mark;
        $test->save();
        return redirect('/test')->with('success', 'Test Created Successfully!');
    }

    public  function edit($id)
    {
        $company = User::where('parent_id', 1)->get();
        $test = Test::findorfail($id);
        $tabname = Coursetab::where('admin_id', $test->user_id)->get();
        // dd($tabname);
        return view('auth.test.edit', compact('test', 'company', 'tabname'));
    }

    public function update(Request $request, $id)
    {
        $test = Test::findorfail($id);
        $test->user_id = $request->company_name;
        $test->tab_id = $request->section;
        $test->marks = $request->marks;
        $test->time = $request->time;
        $test->passing_mark = $request->passing_mark;
        $test->update($request->all());
        return redirect('/test')->with('success', 'Test Updated Successfully!');
    }

    public function destroy($id)
    {
        $test = Test::findorfail($id);
        $test->delete();
        return redirect('/test')->with('success', 'Test Deleted Successfully!');
    }

    public function questionForm($id)
    {
        $test = Test::findorfail($id);
        $que = Question::where('test_id', $test->id)->get();
        $total = Question::where('test_id', $test->id)->get()->sum('que_mark');
        // dd($total);
        return view('auth.question.index', compact('test', 'que', 'total'));
    }

    public function addQuestion($id)
    {
        $test = Test::findorfail($id);
        return view('auth.question.create', compact('test'));
    }


    public function showQuestion($id)
    {
        $que = Question::findorfail($id);
        $option = Option::where('question_id', $que->id)->get();
        $ans = QuestionAnswer::where('question_id', $que->id)->first();
        return view('auth.question.show', compact('que', 'option', 'ans'));
    }

    public function testResult(){
        if(Auth::user()->parent_id == 0){
            $student = User::where('acc_type', "user")->get();
        }
        else{
            $student = User::where('acc_type', "user")->where('parent_id', Auth::user()->id)->get();
        }
        // dd($student);
        $takeTest = TakeTest::all();
        return view('auth.result', compact('takeTest', 'student'));
    }

    public function viewTest($id)
    {
        $student = User::findorfail($id);
        // dd($student);
        $takeTest = TakeTest::where('user_id', $id)->get();
        // dd($takeTest);
        return view('auth.users.testResult', compact('takeTest', 'student'));
    }
}
