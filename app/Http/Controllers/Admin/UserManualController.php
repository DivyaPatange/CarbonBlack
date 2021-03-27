<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\UserManual;

class UserManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manuals = UserManual::all();
        return view('auth.user-manual.index', compact('manuals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'file' => 'required',
            'user_type' => 'required',
        ]);
        $manual = new UserManual();
        $cvrimage = $request->file('file');
        $image_name = rand() . '.' . $cvrimage->getClientOriginalExtension();
        // $cvrimage->storeAs('public/tempcourseimg',$image_name);
        $cvrimage->move(public_path('UserManual'), $image_name);
        $manual->file = $image_name;
        $manual->manual_for = $request->user_type;
        $manual->save();
        return redirect('user-manual')->with('success', 'Manual Added Successfully');
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
        $manual = UserManual::findorfail($id);
        return view('auth.user-manual.edit', compact('manual'));
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
        $manual = UserManual::findorfail($id);
        
        $image_name = $request->hidden_image;
        $image = $request->file('file');
        if($image != '')
        {
            $request->validate([
                'file' => 'required',
                'user_type' => 'required',
            ]);   
            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            // $image->storeAs('public/tempcourseimg',$image_name);
            $image->move(public_path('UserManual'), $image_name);
        }
        $input_data = array (
            'file' => $image_name,
            'manual_for' => $request->user_type,
        );
        UserManual::whereId($id)->update($input_data);
        return redirect('user-manual')->with('success', 'Manual Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manual = UserManual::findorfail($id);
        if($manual->file){
            unlink(public_path('UserManual/'.$manual->file));
        }
        $manual->delete();
        return redirect('user-manual')->with('success', 'Manual Deleted Successfully');
    }
}
