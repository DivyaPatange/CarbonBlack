<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetMail;
use Illuminate\Support\Facades\Mail;
use Redirect;
use Crypt;

class ResetPasswordController extends Controller
{
    public function resetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $email = $request->email;
        $row = User::where('email', '=', $email)->first();
        $id = $row->id;
        if(!empty($email) && isset($id))
        {
            $newpassword = Str::random(8);
            $result = User::where('id',$id)->update(['password' => Hash::make($newpassword), 'password_1' => $newpassword]);
            $user = User::where('email', $request->email)->first();
            if($result)
            {
                // dd( Mail::to($email)->send(new ResetMail($user)));
                Mail::to($email)->send(new ResetMail($user));
                return redirect('/login')->with('success', 'Your password has been reset successfully and sent to your email address');
                
            }
            else
            {
                return Redirect::back()->with('danger', 'Failed to reset password');
            }
        }
    }
    
    
}
