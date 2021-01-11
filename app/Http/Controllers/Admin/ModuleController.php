<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\TakeTest;
use App\Admin\Attempt;
use Auth;
use Redirect;
use DB;

class ModuleController extends Controller
{
    public function index()
    {
        $tab = DB::table('coursetabs')->where('admin_id', Auth::user()->id)->get();
        // dd($tab);
        return view('auth.moduleReactivate.index', compact('tab'));
    }

    public function testEnabled($id)
    {
        $attempt = Attempt::findorfail($id);
        $attempt->status = 1;
        $attempt->save();
        $takeTest = TakeTest::where('user_id', $attempt->user_id)
                    ->where('test_id', $attempt->test_id)->get();
        foreach($takeTest as $test)
        {
            $test->is_verified = 0;
            $test->save(); 
        }
        return Redirect::back()->with('success', 'Test is enabled.');
    }
}
