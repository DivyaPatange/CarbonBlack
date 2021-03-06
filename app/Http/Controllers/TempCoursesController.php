<?php

namespace App\Http\Controllers;

use App\TempCourses;
use App\Coursetab;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Redirect;
use App\Admin\UserCourse;

class TempCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coursetab = Coursetab::orderBy('course_id')->where('admin_id', '=', Auth::user()->id)->where('status', 1)->get();
        $tempcourses = TempCourses::orderBy('title')->where('admin_id', '=', Auth::user()->id)->get();
        // dd($tempcourses);

        $user = User::findorfail(Auth::user()->id);
        $getCourse = UserCourse::where('user_id', Auth::user()->id)->first();
        // dd($user);
        if(Auth::user()->acc_type == "user"){
            $userCourses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->get();
            if((Auth::user()->designation == "Sr. Manager") || (Auth::user()->designation == "Manager")){
                $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->get();
            }
            if((Auth::user()->designation == "Sr. Engineer") || (Auth::user()->designation == "Engineer")){
                $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->limit(3)->get();
            }
            if(Auth::user()->designation == "Trainee"){
                $searchValue = "Introduction";
                $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->where('name', 'like', "%{$searchValue}%")->get();   
            }
            else{
                $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->get();
            }
            $courseArray = array();
            foreach($courses as $course)
            {
                $courseArray[] = $course->course_id;
            } 
            if(empty($getCourse))
            {
                $userCourse = new UserCourse;
                $userCourse->user_id = Auth::user()->id;
                $userCourse->user_course_id = implode(",", $courseArray);
                $userCourse->save();
            }
        }
        $tempCourses = TempCourses::orderBy('title')->where('admin_id', '=', $user->parent_id)->get();
    //     $tempcourses = Coursetab::join('temp_courses', 'temp_courses.category', '=', 'coursetabs.name')
    //   ->select('coursetabs.course_id', 'coursetabs.name', 'temp_courses.*')
    //   ->get();
        return view('auth.tempCoursesData.index', compact('tempcourses', 'tempCourses'))->with('coursetab',$coursetab);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $users = User::findorfail($id);
        $coursetab = Coursetab::where('admin_id', $id)->get();
        // dd($coursetab);
        return view('auth.tempCoursesData.create', compact('users'))->with('coursetab',$coursetab);
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
            'admin_id' => 1,
        );
        TempCourses::create($input_data);
        session()->flash('status', 'Course Created Successfully');
        return Redirect::back();
        
    }

      public function storetab(Request $request, $id)
     {
        $coursetab = Coursetab::all();
        $request->validate([
            'name' => 'required',
        ]);
        $admin_id = User::where('id', $id)->first();
        // dd($admin_id);
        $input_data = array (
            'name' => $request->name,
            'admin_id' => $admin_id->id,
            );
        Coursetab::create($input_data);
        session()->flash('status', 'New Course Tab Created successfully');
        return Redirect::back()->with('coursetab',$coursetab);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\TempCourses  $tempCourses
     * @return \Illuminate\Http\Response
     */
    public function show(TempCourses $tempCourses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TempCourses  $tempCourses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tempcourses = TempCourses::findorfail($id);
        // $course = Coursetab::where('admin_', '=', $tempcourses->category)->first();
        // dd($course);
        $coursetab = Coursetab::where('admin_id', '=', $tempcourses->admin_id)->get();
        return view('auth.tempCoursesData.edit', compact('tempcourses'))->with('coursetab',$coursetab);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TempCourses  $tempCourses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $image_name = $request->hidden_image;
        $image = $request->file('img');
        if($image != '')
        {
            $request->validate([
                'title' => 'required',
                'img' => 'image|max:2048',
                'category' => 'required',
                'path' => 'required'
            ]);
        $image_name = rand() . '.' . $image->getClientOriginalExtension();
        // $image->storeAs('public/tempcourseimg',$image_name);
        $image->move(public_path('courseImg'), $image_name);
        }
        else{
            $request->validate([
                'title' => 'required',
                'img' => 'image|max:2048',
                'category' => 'required',
                'path' => 'required'
            ]);
        }
        $input_data = array (
            'title' => $request->title,
            'img' => $image_name,
            'category' => $request->category,
            'description' => $request->description,
            'path' => $request->path
        );

        TempCourses::whereId($id)->update($input_data);
        session()->flash('status', 'Course Updated successfully');
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TempCourses  $tempCourses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tempCourses = TempCourses::findorfail($id);
        $tempCourses->delete();
        session()->flash('status', 'Course Deleted successfully');
        return Redirect::back();
    }
    public function destroytab($id)
    {
        $coursetab = Coursetab::findorfail($id);
        $coursetab->delete();
        session()->flash('status', 'Tab Deleted successfully');
        return Redirect::back()->with('coursetab',$coursetab);
        
    }

    public function storeCourse(Request $request, $id)
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
            'admin_id' => $request->admin_id,
        );
        TempCourses::create($input_data);
        session()->flash('status', 'Course Created Successfully');
        return Redirect::back();
    }
}
