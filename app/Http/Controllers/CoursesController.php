<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use App\Coursetab;
use App\TempCourses;
use App\Admin\UserCourse;
use App\User;
    
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
        $tab = Coursetab::where('course_id', $id)->first();
        if($tab->status == 1)
        {
            $tab->status = 0;
        }
        else{
            $tab->status = 1;
        }
        $tab->save();
        return Redirect::back()->with('status', 'Status Changed Successfully!');
    }

    public function getCourse(Request $request)
    {
        $getCourse = UserCourse::where('user_id', $request->bid)->first();
        // return $getCourse;
        $user = User::findorfail($request->bid);
        $userCourses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->get();
        // dd($user);
        if(($user->designation == "Sr. Manager") || ($user->designation == "Manager")){
            $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->get();
        }
        if(($user->designation == "Sr. Engineer") || ($user->designation == "Engineer")){
            $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user->parent_id)->where('status', 1)->limit(3)->get();
        }
        if($user->designation == "Trainee"){
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
            $userCourse->user_id = $request->bid;
            $userCourse->user_course_id = implode(",", $courseArray);
            $userCourse->save();
        }
        $getUserCourse = UserCourse::where('user_id', $request->bid)->first();
        $explodeCourse = explode(",", $getUserCourse->user_course_id);
        $output = "";
        foreach($userCourses as $userCourse)
        {
            $output .= '<tr>'.
                '<td>'.$userCourse->name.'</td>'. 
                '<td>';
                if(in_array($userCourse->course_id, $explodeCourse)){
                    $output .= '<input type="checkbox" name="courses" checked value="'.$userCourse->course_id.'">';
                }
                else{
                    $output .= '<input type="checkbox" name="courses" value="'.$userCourse->course_id.'">';
                }
                $output .= '</td>'.
            '</tr>';
        }
        $data = array('user_id' => $request->bid, 'courses' => $output);
        echo json_encode($data);
    }

    public function updateCourse(Request $request)
    {
        $getCourse = UserCourse::where('user_id', $request->user_id)->update(['user_course_id' => implode(",", $request->userCourse)]);
        return response()->json(['success' => 'Data Updated Successfully!']);
    }
}
