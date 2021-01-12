@extends('auth.admin_layouts.main')

@section('title','Signature Pad')

@section('customcss')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">


 
  

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 

    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 

    

  

    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <style>
       .hidden{
           display:none;
       }
       .kbw-signature { width: 100%; height: 200px;}

        #sig canvas{

            width: 100% !important;

            height: auto;

        }
    </style>
@endsection

@section('content')
<div class="mdc-layout-grid">
@if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    
  <div class="mdc-layout-grid__inner">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0">Signature Pad</h6>
        <div class="table-responsive p-4">
        <form method="POST" action="{{ route('signaturepad.upload') }}">

@csrf

<div class="col-md-12">

    <label class="" for="">Signature:</label>

    <br/>

    <div id="sig" ></div>

    <br/>
    <button id="clear" class="mdc-button mdc-button--raised filled-button--secondary mdc-ripple-upgraded" style="--mdc-ripple-fg-size:65px; --mdc-ripple-fg-scale:1.92922; --mdc-ripple-fg-translate-start:-9.5px, -7.5px; --mdc-ripple-fg-translate-end:22.3203px, -14.5px;">
    Clear Signature
                    </button>   

    <textarea id="signature64" name="signed" style="display: none"></textarea>

</div>

<br/>
<button class="mdc-button mdc-button--raised filled-button--success mdc-ripple-upgraded">
Save
</button>

</form>
        </div>
      </div>
    </div>
  </div>
    
</div>



   
 
@endsection
@section('customjs')
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
<script type="text/javascript">

    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});

    $('#clear').click(function(e) {

        e.preventDefault();

        sig.signature('clear');

        $("#signature64").val('');

    });

</script>
@endsection