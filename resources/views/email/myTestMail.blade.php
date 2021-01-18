<!DOCTYPE html>
<html>
<head>
<<<<<<< HEAD
    <title>Certificate</title>
</head>
<body>
<table width="" class="centered">
      <tr>
        <td width="50%"><img src="{{ asset('assets/frontend/img/logo/logo.png') }}" width="150px" height="90px">
        </td>
        <td><?php
              $employee = DB::table('users')->where('id', Auth::user()->id)->first();
              // dd($employee);
              $logo1 = DB::table('company_logo')->where('user_id', $employee->parent_id)->first();
          ?>
          @if(!empty($logo1))
           <img src="{{ URL::to('/') }}/logo/{{$logo1->logo}}" width="90px" height="90px" style="float:right;">@endif</td>
      </tr>
      <tr>
        <td colspan="2"><h1 class="text-center mt-3">Certificate of Training</h1></td>
      </tr>
      <tr>
        <td colspan="2">
        <p class="mt-3">This Certifies that</p>
        </td>
      </tr>
      <tr>
        <td colspan="2"><h2 class="certificate_name">{{ Auth::user()->name }}</h2></td>
      </tr>
      <tr>
        <td colspan="2">
        <p>Has Successfully completed the training in <b>CARBON BLACK TECHNOLOGY</b> for the training program requirement for</p>
              <?php 
              // dd($takeTest);
              $test = DB::table('test')->where('id', $takeTest->test_id)->first();
              $section = DB::table('coursetabs')->where('course_id', $test->tab_id)->first();
              $newtime = strtotime($takeTest->created_at);
                $takeTest->time = date('M d, Y',$newtime);
                // dd($takeTest->time);
              ?>
        </td>
      </tr>
      <tr>
        <td colspan="2"> <h3>{{ $section->name }}</h3></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:center"><h4 class="date_border">{{ $takeTest->time }}</h4></td>
      </tr>
      <tr>
        <td colspan="2">
        <h6 style="text-align:center">DATE</h6></td>
      </tr>
    </table>
=======
    <title>ItsolutionStuff.com</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>
     
    <p>Thank you</p>
>>>>>>> f4a703fe51ceeef9b1bc4b0de68ddbbfd23b32de
</body>
</html>