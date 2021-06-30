<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Gate;
use Auth;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivateConfirmMail;
use App\Admin\Logo;
use DB;
use DataTables;
use App\Admin\UserCourse;
use App\Coursetab;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;   
        $users = User::where('parent_id', '=', $id)->get();
        $result = User::findorfail($id);
        $emp = User::where('parent_id', '=', NULL)->orderBy('id', 'DESC')->get();
        if(request()->ajax()) {
            return datatables()->of($emp)
            ->addColumn('company', function($row){    
                $id = Auth::user()->id;    
            $users = User::where('parent_id', '=', $id)->get();
                $output = '';
               $output .='<select class="form-control company_name'.$row->id.'" name="company_name">
                            <option value="">- Select Company -</option>';
                            foreach($users as $u){
                            $output .='<option value="'.$u->id.'">'.$u->name.'</option>';
                            }
                            $output .='</select>'; 
                            return $output;                                                                                                                                                                                                                                                                                 
            })
            ->addColumn('action', 'auth.users.action')
            ->rawColumns(['action', 'company'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('auth.users.index', compact('result', 'emp'))->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);
        $input_data = array (
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'department' => $request->department,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pin' => $request->pin,
            'password' => Hash::make($request['password']),
            'acc_type' => $request->acc_type,
            'status' => false,
        );

        $user = User::create($input_data);
        return redirect('loginform')->with([
            'user' => $user
        ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id)
    {
        $user = User::find($id);
        if($user->status == 0)
        {
            $user->status = 1;
            $user->save();
            // dd($data->name);
            if($user->save())
            {
            Mail::to($user->email)->send(new ActivateConfirmMail($user));
            return Redirect::back()->with('user', $user);
            }
        }
        else{
            $user->status = 0;
            $user->save();
        return Redirect::back();
        }
        
    }
    public function update(Request $request, $id)
    {
        $user = User::findorfail($id);
        $branchId = DB::table('users')->where('parent_id', $request->company_name)->max('code');
        
        if(!empty($branchId))
        {
            $Enq= User::where('code', $branchId)->first();
            // dd($Enq);
            $string = $Enq->registration_code;
            $string = $Enq->registration_code;
            $int = intval(preg_replace('/[^0-9]+/', '', $string), 10);
            
            $en=$int+1;
            $user->parent_id = $request->company_name;
            $companyName = User::where('id', $request->company_name)->first();
            $user->code = $en;
            // dd($companyName);
            $user->registration_code  = strtoupper($companyName->name)."".sprintf("%05d", $en);
        }
        else{
            $user->parent_id = $request->company_name;
            $companyName = User::where('id', $request->company_name)->first();
            $user->code = 1;
            $user->registration_code  = strtoupper($companyName->name)."00001";
        }
        // dd($branchId);
        $user->update($request->all());
        $user1 = User::where('id', $id)->first();
        $userCourses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user1->parent_id)->where('status', 1)->get();
        // dd($user);
        if(($user1->designation == "Sr. Manager") || ($user1->designation == "Manager")){
            $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user1->parent_id)->where('status', 1)->get();
        }
        if(($user->designation == "Sr. Engineer") || ($user->designation == "Engineer")){
            $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user1->parent_id)->where('status', 1)->limit(3)->get();
        }
        if($user->designation == "Trainee"){
            $searchValue = "Introduction";
            $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user1->parent_id)->where('status', 1)->where('name', 'like', "%{$searchValue}%")->get();   
        }
        else{
            $courses = Coursetab::orderBy('course_id')->where('admin_id', '=', $user1->parent_id)->where('status', 1)->get();
        }
        $courseArray = array();
        foreach($courses as $course)
        {
            $courseArray[] = $course->course_id;
        }
        $getCourse = UserCourse::where('user_id', $id)->first();
        if(empty($getCourse)){
            $userCourse = new UserCourse;
            $userCourse->user_id = $id;
            $userCourse->user_course_id = implode(",", $courseArray);
            $userCourse->save();
        }
        return response()->json(['success' => 'User Updated Successfully!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->delete();
        return Redirect::back()->with('success', 'User deleted successfully!');
    }
    public function destroyEmployee($id)
    {
        $user = User::findorfail($id);
        $user->delete();
        return response()->json(['success' => 'User Deleted Successfully!']);
    }

    public function resetpas()
    {
        return view('auth.resetpasswrd');
    }


    public function editProfile()
    {
        $user = User::findorfail(Auth::user()->id);
        $userInfo = Logo::where('user_id', $user->id)->first();
        // dd($userInfo);
        return view('auth.users.editProfile', compact('user', 'userInfo'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findorfail($request->id);
        // dd($user);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact_no' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required', 
        ]);
        $updateUser = User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->contact_no,
            'designation' => $request->designation,
            'department' => $request->department,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'pin' => $request->pin_code,
        ]);
        $userInfo = Logo::where('user_id', $user->id)->first();

        if($request->signed)
        {        
            $folderPath = public_path('upload/');
            $image_parts = explode(";base64,", $request->signed);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.'.$image_type;
            $file = $folderPath . $fileName;
            // dd($fileName);
            file_put_contents($file, $image_base64);
            if(empty($userInfo))
            {
                $userInfo = new Logo();
                $userInfo->user_id = $request->id;
                $userInfo->signature_img = $fileName;
                $userInfo->save();
            }
            else{
                $userInfo = Logo::where('user_id', $request->id)->update([
                    'signature_img' =>$fileName,
                ]);
            }
        }
        return Redirect::back()->with('success', 'Profile Updated Successfully');
    }
    
   
    
}
