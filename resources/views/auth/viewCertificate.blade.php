<!DOCTYPE html>
<html>
<head>
<title>Carbon Black Education | Certificate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style> 
#img{
    background-image: url('../img/image1.png');
    width:100%;
    background-size: cover;
    height: 800px;
    position: relative;
    /* height: 100%; */
}
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 75%;
  height:600px;
  transform: translate(-50%, -50%);
  border: 3px solid #f0dfbe;
}
.certificate_name{
  color: #b34a00;
  margin-bottom:25px;
}
.date_border{
  display:inline-flex;
  color: #b34b00;
  border-bottom: 1px solid #496883;
  padding:10px 20px;
  margin-bottom:0px;
}
.heading h1{
  color: #3a5570;
  font-size: 54px;
  font-weight: 700;
  letter-spacing:4px;
  margin-bottom: 25px;
}
.heading p{
  font-size: 20px;
  color: #445e77;
  /* font-weight:500; */
  margin-bottom: 25px;
}
.heading h6{
  color: #647a8f;
}
.heading h3{
  color: #3a5570;
  margin-bottom: 30px;
}
</style>

</head>
<body>

<div class="container-fluid" id="pdfdiv">
    <div class="row">
        <div class="col-12">
        <div class="text-center">
          <img src="{{ asset('img/image1.png') }}" width="100%" height="900px">
           <div class="centered">
           <div class="float-left p-3">
              <img src="{{ asset('assets/frontend/img/logo/logo.png') }}" width="150px" height="90px">
           </div>
           <div class="float-right p-3">
           <?php
              $employee = DB::table('users')->where('id', Auth::user()->id)->first();
              // dd($employee);
              $logo1 = DB::table('company_logo')->where('user_id', $employee->parent_id)->first();
          ?>
          @if(!empty($logo1))
           <img src="{{ URL::to('/') }}/logo/{{$logo1->logo}}" width="90px" height="90px">
           @endif
           </div>
           <div class="clearfix"></div>
           <div class="heading">
              <h1 class="text-center mt-3">Certificate of Training</h1>
              <p class="mt-3">This Certifies that</p>
              <h2 class="certificate_name">{{ Auth::user()->name }}</h2>
              <p>Has Successfully completed the training in <b>CARBON BLACK TECHNOLOGY</b> for the training program requirement for</p>
              <?php 
              // dd($takeTest);
              $test = DB::table('test')->where('id', $takeTest->test_id)->first();
              $section = DB::table('coursetabs')->where('course_id', $test->tab_id)->first();
              $newtime = strtotime($takeTest->created_at);
                $takeTest->time = date('M d, Y',$newtime);
                // dd($takeTest->time);
              ?>
              <h3>{{ $section->name }}</h3>
              <h4 class="date_border">{{ $takeTest->time }}</h4>
              <h6>DATE</h6>
              </div>
           </div>
        </div>
        </div>
    </div>
</div>
<div id="editor"></div>
<div class="container-fluid">
<div class="col-12">
<div class="text-center">
<button type="button" id="btnExport" onclick="Export()" class="mdc-button mb-4 mdc-button--raised filled-button--info">
     Download
</button>
</div>
</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
function Export() {
            html2canvas(document.getElementById('pdfdiv'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("certificate.pdf");
                }
            });
        }

</script>
</body>
</html>
