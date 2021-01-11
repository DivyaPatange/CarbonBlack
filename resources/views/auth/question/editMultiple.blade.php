
@extends('auth.admin_layouts.main')
@section('title','Edit Question')
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
        <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>Edit Question</b></h6>
        <form action="{{ route('question.multiple.update', $que->id) }}" enctype="multipart/form-data" method="post">
          <div class="mdc-card">
          @csrf
            @method('PUT')
            <div class="template-demo">
              <div class="mdc-layout-grid__inner">
                {{-- course name --}}
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <textarea class="mdc-text-field__input" rows="5" name="question" id="question">{{ $que->question }}</textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Question</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <textarea class="mdc-text-field__input" rows="2" name="que_hint" id="que_hint">{{ $que->que_hint }}</textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Hint</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                @foreach($option as $o)
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <input class="mdc-text-field__input"  name="option_{{ $o->option_number }}" id="option_1" value="{{ $o->option_title }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Option {{ $o->option_number }}</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                @endforeach
                <?php
                    $auth= $ans->correct_ans;
                    $autharray = explode(",", $auth);
                ?>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                        <div class="mdc-form-field">Correct Ans:</div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" value="1" name="correct_ans[]"  {{ in_array( 1 ,  $autharray)?  'checked' :  '' }}>
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Option 1</label>
                        </div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control"  value="2" name="correct_ans[]" {{ in_array( 2 , $autharray)?  'checked' :  '' }}>
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Option 2</label>
                        </div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" value="3" name="correct_ans[]" {{ in_array( 3 , $autharray)?  'checked' :  '' }}>
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Option 3</label>
                        </div>
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox mdc-checkbox--info">
                                <input type="checkbox" id="basic-disabled-checkbox" class="mdc-checkbox__native-control" value="4" name="correct_ans[]"  {{ in_array( 4 , $autharray)?  'checked' :  '' }}>
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="basic-disabled-checkbox" id="basic-disabled-checkbox-label">Opion 4</label>
                        </div>
                    </div>
                </div>
                  {{-- //course name --}}
                  <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="que_mark" id="que_mark" value="{{ $que->que_mark }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Question Mark</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop text-center">
                <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                       Update Question
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
  
  
     
@endsection
@section('customjs')


@endsection
