<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Redirect;
use App\User;
use Auth;
use Route;
use App\Rules\MatchOldPassword;


class ChangePasswordController extends Controller
{
    public function ChangePasswordForm()
    {
        return view('auth.changepass');
    }

    public function ChangePasswordStore(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'renew_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password), 'password_1' => $request->new_password]);
   
        return redirect('/home')->with('success', 'Password Changed Successfully!');
    }
}
