
@extends('auth.admin_layouts.main')

@section('title','Test')

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
  @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    
  <div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>Edit Test</b></h6>
        <form action="{{ route('test.update', $test->id) }}" enctype="multipart/form-data" method="post">
          <div class="mdc-card">
          @csrf
          @method('PUT')
            <div class="template-demo">
              <div class="mdc-layout-grid__inner">
                {{-- course name --}}
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <select class="mdc-text-field__input dynamic" name="company_name" id="company_name">
                
                        @foreach($company as $c)
                        <option value="{{ $c->id}}" {{ ($c->id == $test->user_id) ? 'selected=selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Select Company</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <select class="mdc-text-field__input dynamic" name="section" id="section">
                    @foreach($tabname as $tab)
                    <option value="{{ $tab->course_id}}" {{ ($test->tab_id == $tab->course_id) ? 'selected=selected' : '' }}>{{ $tab->name }}</option>
                    @endforeach
                    </select>
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Select Section</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="marks" id="marks" value="{{ $test->marks }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Total Marks</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="time" id="time" value="{{ $test->time }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Time (in Min.)</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="passing_mark" id="passing_mark" value="{{ $test->passing_mark }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Passing Mark</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                  {{-- //course name --}}

                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop text-center">
                <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                       Edit Test
                </button>
                </div>
              </div>
              <!-- </div> -->
            </div>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
     
@endsection
@section('customjs')

<script type="text/javascript">
    jQuery(document).ready(function ()
    {
            jQuery('select[name="company_name"]').on('change',function(){
               var companyID = jQuery(this).val();
               if(companyID)
               {
                  jQuery.ajax({
                     url : '/tablist/' +companyID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="section"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="section"]').append('<option value="'+ value.course_id +'">'+ value.name +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="section"]').empty();
               }
            });
    });

    
    </script>

@endsection
