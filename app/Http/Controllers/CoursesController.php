<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Coursetab;
use App\TempCourses;
    
class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursetab = Coursetab::orderBy('course_id')->where('admin_id', '=', Auth::user()->id)->get();
        // dd($coursetab);
        $tempcourses = TempCourses::orderBy('title')->where('admin_id', '=', Auth::user()->id)->get();
        return view('auth.tempCoursesData.courses', compact('coursetab', 'tempcourses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coursetab = Coursetab::where('admin_id', 1)->get();
        return view('auth.tempCoursesData.createtab', compact('coursetab'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        // dd($admin_id);
        $input_data = array (
            'name' => $request->name,
            'admin_id' => Auth::user()->id,
            );
        Coursetab::create($input_data);
        session()->flash('status', 'New Course Tab Created successfully');
        return Redirect::back();
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courses = Course::findorfail($id);
        return view('auth.coursesData.show')->with('courses', $courses);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tab = Coursetab::where('course_id', $id)->first();
        // dd($tab);
        return view('auth.coursesData.edit', compact('tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tab = Coursetab::where('course_id', $id)->first();
        $tab->name = $request->name;
        $tab->update($request->all());
        return Redirect::back()->with('status', 'Tab Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findorfail($id);
        $course->delete();
        return redirect('coursesData');
    }

    public function storeModule(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'img' => 'required|image|max:2048',
            'category' => 'required',
            'description' => 'required',
            'path' => 'required'
        ]);
        $cvrimage = $request->file('img');
        $image_name = rand() . '.' . $cvrimage->getClientOriginalExtension();
        // $cvrimage->storeAs('public/tempcourseimg',$image_name);
        $cvrimage->move(public_path('courseImg'), $image_name);

        $input_data = array (
            'title' => $request->title,
            'img' => $image_name,
            'category' => $request->category,            
            'description' => $request->description,
            'path' => $request->path,
            'admin_id' => 1
        );
        TempCourses::create($input_data);
        session()->flash('status', 'Course Created Successfully');
        return redirect()->route('tempCoursesData.coursesAll');
        
    }

    public function status($id)
    {
        $courseTab = Coursetab::findorfail($id);
        // dd($courseTab);
        if($courseTab->status == 1)
        {
            $courseTab->status = 0;
            $courseTab->save();
        }
        else{
            $courseTab->status = 1;
            $courseTab->save();
        }
        return Redirect::back()->with('status', 'Status changed successfully!');
    }

}
