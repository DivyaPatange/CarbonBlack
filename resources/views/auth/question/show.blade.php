
@extends('auth.admin_layouts.main')
@section('title','Test Question')
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
            <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>{{ $que->question }}</b></h6>
            <div class="mdc-card">
                <div class="template-demo">
                    <div class="mdc-layout-grid__inner">
                    @foreach($option as $key => $o)
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox mdc-checkbox--success">
                                    <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label"><b>{{ ++$key }}.</b> {{$o->option_title}}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  
     
@endsection
@section('customjs')


@endsection
