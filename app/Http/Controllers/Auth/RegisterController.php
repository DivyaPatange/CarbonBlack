<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Role;
use Illuminate\Http\Request;  
use Illuminate\Auth\Events\Registered;  
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendMail;
use App\Mail\ActivateConfirmMail;
use App\Mail\UserActivateMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'=> ['required','min:10'],
            'designation' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'pin' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms_and_condition' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'designation' => $data['designation'],
            'department' => $data['department'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'pin' => $data['pin'],
            'password' => Hash::make($data['password']),
            'password_1' => $data['password'],
            'acc_type' => 'user',
            'status' => false,
        ]);
        // dd($user);
        $userRole = Role::where('acc_type', 'user')->first();
        $user->roles()->attach($userRole);
        Mail::to("carbonblack.education@gmail.com")->send(new UserActivateMail($user));
        Mail::to($data['email'])->send(new SendMail($user));
        return $user;
    }
    public function register(Request $request)
    {
    $this->validator($request->all())->validate();
    event(new Registered($user = $this->create($request->all())));
    return redirect($this->redirectTo)->with('success', 'Register Succesfully');
    
    }
    public function activate($id)
    {
        $user = User::findorfail($id);
        if($user->status == 0)
        {
            $user->status = 1;
            $user->save();
            if($user->save())
            {
                Mail::to($user->email)->send(new ActivateConfirmMail($user));
                return redirect('/login')->with('success', 'Account is activated');
            }
        }
        else{
            return redirect('/login')->with('danger', 'Account is already activated');
        }
        

    }
}
