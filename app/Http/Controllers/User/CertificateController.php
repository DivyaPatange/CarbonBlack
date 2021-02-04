<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\TakeTest;
use Auth;
use App\User;
use PDF;
use DB;
use Mail;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        $takeTest = DB::table('take_test')->where('id', $id)->first();
        // dd($takeTest);
        $data["email"] = "divyapatange0@gmail.com";
        $data["title"] = "Test Certificate";
        $data["body"] = "You have successfully passed the test. Please find attachment of certificate below.";
        $folderPath = public_path('certificate/');
        $takeTestArray = (array)$takeTest;
        // dd($takeTestArray);
        $pdf = PDF::loadView('auth.mailCertificate', $takeTestArray);
        $fileName = uniqid() . '.pdf';

        $file = $folderPath . $fileName;
        $path = file_put_contents($file, $pdf->output());
        // dd($file);
        $pdfFile = public_path('certificate/'.$fileName);
        Mail::send('email.myTestMail', $data, function($message)use($data, $pdfFile) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attach($pdfFile);
            
        });
        // $user = User::where('id', $takeTest->user_id)->first();
        // $data["email"]=$user->email;
        // $data["client_name"]=$user->name;
        // $data["subject"]="Test Certificate";

        // $pdf = PDF::loadView('auth.viewCertificate', compact('data', 'takeTest'));

        // try{
        //     Mail::send('auth.viewCertificate', compact('data', 'takeTest'), function($message)use($data,$pdf,$takeTest) {
        //     $message->to($data["email"], $data["client_name"])
        //     ->subject($data["subject"])
        //     ->attachData($pdf->output(), "invoice.pdf");
        //     });
        // }catch(JWTException $exception){
        //     $this->serverstatuscode = "0";
        //     $this->serverstatusdes = $exception->getMessage();
        // }
        // if (Mail::failures()) {
        //      $this->statusdesc  =   "Error sending mail";
        //      $this->statuscode  =   "0";

        // }else{

        //    $this->statusdesc  =   "Message sent Succesfully";
        //    $this->statuscode  =   "1";
        // }
        // return response()->json(compact('this'));
        // $data["email"] = "shreeyabondre78@gmail.com";

        // $data["title"] = "From HDTuto.com";

        // $data["id"] = $takeTest->id;
            // dd($data["id"]);
  

        // $pdf = PDF::loadView('auth.viewCertificate', compact('takeTest'));
        // $path = public_path('pdf');
        // dd($pdf->save($path . '/text.pdf', $pdf->output()));
        // $pdf->save($path . '/text.pdf', $pdf->output());
        // Storage::put($path, $pdf->output());
        // dd(Storage::put('public/pdf/invoice.pdf', $pdf->output()));

        // return $pdf->download('invoice.pdf');

        // Mail::send('email.myTestMail', $data, function($message)use($data, $pdf) {

        //     $message->to($data["email"], $data["email"])

        //             ->subject($data["title"])

        //             ->attachData($pdf->output(), "text.pdf");

        // });

  

        dd('Mail sent successfully');
    }
}
