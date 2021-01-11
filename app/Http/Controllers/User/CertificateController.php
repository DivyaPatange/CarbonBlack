<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\TakeTest;
use Auth;

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
}
