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
use DB;

class DesignController extends Controller
{
    public function index()
    {
        $coursetab = Coursetab::orderBy('course_id')->where('admin_id', 1)->where('status', 1)->get();
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
            // 'g-recaptcha-response' => 'required|captcha',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'country' => 'required',
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
            $contact->message = $request->message;
            $contact->save();
            if($contact->save())
            {
                $contactus = DB::table('contacts')->where('id', $contact->id)->first();
                // dd($contactus);
                $contactArray = (array)$contactus;
                // dd($contactArray);
                $data["email"] = "divyapatange0@gmail.com";
                $data["title"] = "Enquiry Message";
                $data["body"] = "New User Enquiry Submitted";
                Mail::send('email.contactMail', $contactArray, function($message)use($data, $contactArray) {
                    $message->to($data["email"], $data["email"])
                            ->subject($data["title"]);
                    
                });
            }
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
