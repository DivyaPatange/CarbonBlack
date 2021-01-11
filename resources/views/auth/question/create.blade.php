
@extends('auth.admin_layouts.main')

@section('title','Question')

@section('customcss')
<script src="http://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
      <style>
     .files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 0;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}

    </style>
     <script src="http://www.codermen.com/js/jquery.js"></script>
@endsection

@section('content')

  <div class="mdc-layout-grid">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  @if ($message = Session::get('danger'))
  <div class="alert alert-success alert-block">	
          <strong>{{ $message }}</strong>
  </div>
  @endif
  <div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>Select Question Type</b></h6>
        <form action="{{ route('question.type', $test->id) }}" enctype="multipart/form-data" method="get">
    
          <div class="mdc-card">
            <div class="template-demo">
              <div class="mdc-layout-grid__inner">
                {{-- course name --}}
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <select class="mdc-text-field__input dynamic" name="question_type" id="question_type">
                  <option value=""></option>
                  <option value="single">One Answer</option>
                  <option value="multiple">Multiple Answer</option>
                  <option value="blank">Fill in the blanks</option>
                  <option value="trueorfalse">True or False</option>
                  </select>
                  <div class="mdc-notched-outline">
                    <div class="mdc-notched-outline__leading"></div>
                    <div class="mdc-notched-outline__notch">
                      <label class="mdc-floating-label">Question Type</label>
                    </div>
                    <div class="mdc-notched-outline__trailing"></div>
                  </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-6-desktop ">
                <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                  Get
                </button>
                </div>
                </div>
                  {{-- //course name --}}
              </div>
              <!-- </div> -->
            </div>
            </form>
          </div>
      </div>
    </div>
  </div>
  
  
     
@endsection
@section('customjs')
<script>
   $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
<script>
// $(document).ready(function () {
//     // keyup function looks at the keys typed on the search box
//     $('#question_type').on('change',function() {
//         // the text typed in the input field is assigned to a variable 
//         var query = $(this).val();
//         // call to an ajax function
//         // alert(query != '');
//         if(query != ''){
//         $.ajax({
//             // assign a controller function to perform search action - route name is search
//             url:"{{ route('question.type', $test->id) }}",
//             // since we are getting data methos is assigned as GET
//             type:"GET",
//             // data are sent the server
//             data:{'question_type':query},
//             // if search is succcessfully done, this callback function is called
//             success:function (data) {
//                 // print the search results in the div called country_list(id)
//                 // $('#referral_name').html(data);
//             }
//         });
//         }
//         // end of ajax call
//     });
// })
// </script>
@endsection
