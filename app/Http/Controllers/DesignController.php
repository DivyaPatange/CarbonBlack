<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\TempCourses;
use App\Coursetab;
use App\Subscribe;
use App\Mail\SubscribeMail;
use Illuminate\Support\Facades\Mail;
use App\Contact;
use Illuminate\Support\Facades\Validator;

class DesignController extends Controller
{
    public function index()
    {
        $coursetab = Coursetab::orderBy('course_id')->where('admin_id', 1)->get();
        $tempcourses = TempCourses::orderBy('title')->where('admin_id', 1)->get();
        return view('brand_front.index')
        ->with('courses', Course::all())
        ->with('coursetab',$coursetab)
        ->with('tempcourses', $tempcourses) ;
    }

    public function contactus()
    {
        $coursetab = Coursetab::orderBy('course_id')->where('admin_id', 1)->get();
        $tempcourses = TempCourses::orderBy('title')->where('admin_id', 1)->get();
        return view('brand_front.contactus')
        ->with('courses', Course::all())
        ->with('coursetab',$coursetab)
        ->with('tempcourses', $tempcourses) ;
    }

    public function storeContact(Request $request)
    {
        $messages = [
            'g-recaptcha-response.required' => 'You must check the reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];
 
        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => 'required|captcha',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'country' => 'required',
            'company' => 'required',
            'industry' => 'required',
            'inquiry_category' => 'required',
        ], $messages);
 
        if ($validator->fails()) {
            return redirect('/contact')
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            $contact = new Contact();
            $contact->first_name = $request->first_name;
            $contact->last_name = $request->last_name;
            $contact->email = $request->email;
            $contact->phone_no = $request->phone_no;
            $contact->country = $request->country;
            $contact->company = $request->company;
            $contact->industry = $request->industry;
            $contact->inquiry_category = $request->inquiry_category;
            $contact->existing_client = $request->existing_client;
            $contact->message = $request->message;
            $contact->save();
            return redirect('/contact')->with('success', 'Thank you for contacting us!');
        }
    }
    
    public function loginForm()
    {
        return view('brand_front.login_form.index');
    }
    
    public function storeSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        $subscribe = new Subscribe();
        $subscribe->email = $request->email;
        $subscribe->save();
        
        // dd(Mail::to("divyapatange0@gmail.com")->send(new SubscribeMail($subscribe)));
        Mail::to("carbonblack.education@gmail.com")->send(new SubscribeMail($subscribe));
        return redirect('/');
    }
    
}
