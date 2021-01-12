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
        $emp = User::where('parent_id', '=', NULL)->get();
        // dd($emp);
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
        $branchId = User::where('parent_id', $request->company_name)->get();
        // dd(sprintf("%05d", 1));
        if(count($branchId) > 0)
        {
            $user->parent_id = $request->company_name;
            $companyName = User::where('id', $request->company_name)->first();
            // dd($companyName);
            $user->registration_code  = strtoupper($companyName->name)."".sprintf("%05d", count($branchId));
        }
        else{
            $user->parent_id = $request->company_name;
            $companyName = User::where('id', $request->company_name)->first();
            $user->registration_code  = strtoupper($companyName->name)."00001";
        }
        // dd($branchId);
        $user->update($request->all());
        return Redirect::back()->with('success', 'User updated successfully!');

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
    public function resetpas()
    {
        return view('auth.resetpasswrd');
    }
    
   
    
}
