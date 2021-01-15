<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\TakeTest;
use Auth;
use App\User;
use PDF;
use Illuminate\Support\Facades\Mail;

class CertificateController extends Controller
{
    public function index()
    {
        $takeTest = TakeTest::where('user_id', Auth::user()->id)->get();
        // dd($test);
        return view('auth.certificate', compact('takeTest'));
    }

    public function certificateDownload($id)
    {
        $takeTest = TakeTest::findorfail($id);
        // dd($takeTest);
        return  view('auth.viewCertificate', compact('takeTest'));
    }

    public function sendCertificateMail($id)
    {
        $takeTest = TakeTest::findorfail($id);
        $user = User::where('id', $takeTest->user_id)->first();
        $data["email"]=$user->email;
        $data["client_name"]=$user->name;
        $data["subject"]="Test Certificate";

        $pdf = PDF::loadView('auth.viewCertificate', compact('data', 'takeTest'));

        try{
            Mail::send('auth.viewCertificate', compact('data', 'takeTest'), function($message)use($data,$pdf,$takeTest) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "invoice.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
    }
}
