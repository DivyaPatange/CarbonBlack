<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\TempCourses;
use App\Admin\Logo;
use App\Coursetab;  
use Gate;
use Illuminate\Http\Request;

class AdminRegController extends Controller
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
         $users = User::all();
        return view('auth.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.adminreg.create');
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
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'logo' => 'required|max:2048',
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
            'password_1' => $request->password,
            'password' => Hash::make($request['password']),
            'acc_type' => $request->acc_type,
            'status' => false,
            'parent_id' => $request->parent_id
        );
        

        $user = User::create($input_data);

        $cvrimage = $request->file('logo');
        $image_name = rand() . '.' . $cvrimage->getClientOriginalExtension();
        // $cvrimage->storeAs('public/tempcourseimg',$image_name);
        $cvrimage->move(public_path('logo'), $image_name);
        $input_data1 = array (
            'user_id' => $user->id,
            'logo' => $image_name,
        );
        $logo = Logo::create($input_data1);
        $adminRole = Role::where('acc_type', 'admin')->first();
        $user->roles()->attach($adminRole);
        return redirect()->route('users')->with([
            'user' => $user,
            'logo' => $logo,
        ])->with('success', 'Administrator Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adminReg = User::findorfail($id);

        $logo = Logo::where('user_id', $adminReg->id)->first();
        // dd($logo);
        return view('auth.users.edit', compact('adminReg', 'logo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'unique:users,email,'.$id,
        ]);
        $adminReg = User::findorfail($id);
        $logo = Logo::where('user_id', $id)->first();
        $adminReg->name = $request->name;
        $adminReg->email = $request->email;
        $adminReg->phone = $request->phone;
        $adminReg->designation =  $request->designation;
        $adminReg->department = $request->department;
        $adminReg->city = $request->city;
        $adminReg->state = $request->state;
        $adminReg->country = $request->country;
        $adminReg->pin = $request->pin;
        $adminReg->update($request->all());
        
        $image_name = $request->hidden_image;
        $cvrimage = $request->file('logo');
        if($cvrimage != '')
        {
            $request->validate([
                'logo' => 'required|max:2048',
            ]);
            $image_name = rand() . '.' . $cvrimage->getClientOriginalExtension();
            $cvrimage->move(public_path('logo'), $image_name);
        }
        else{
            
        }
        if(empty($logo))
        {
            $logo = new Logo();
            $logo->user_id = $adminReg->id;
            $logo->logo = $image_name;
            $logo->save();
        }
        else{
            $logo->update(['logo' => $image_name]);
        }
        return redirect('/admin/users')->with('success', 'Administrator Details Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function usersList($id)
    {
        $users = User::findorfail($id);
        $results = User::where('parent_id', '=' , $id)->get();
        
        $coursetab = Coursetab::orderBy('course_id')->where('admin_id', $id)->get();
        $tempcourses = TempCourses::orderBy('title')->where('admin_id', $id)->get();
        return view('auth.userList', compact('results', 'users', 'coursetab', 'tempcourses'));
    }
}
