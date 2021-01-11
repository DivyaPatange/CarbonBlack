
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
       @error('question')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
		@error('option_1')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
		@error('option_2')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
		@error('option_3')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
		@error('option_4')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
		@error('correct_ans')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
		@error('que_mark')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
    @error('que_hint')
		<div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
			<span class="text-danger" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		</div>
		@enderror
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>Add Question</b></h6>
        <form action="{{ route('question.single.store', $test->id) }}" enctype="multipart/form-data" method="post">
          <div class="mdc-card">
          @csrf
            <div class="template-demo">
              <div class="mdc-layout-grid__inner">
                {{-- course name --}}
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <textarea class="mdc-text-field__input" rows="5" name="question" id="question">{{ old('question') }}</textarea> 
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
                  <textarea class="mdc-text-field__input" name="que_hint" id="que_hint">{{ old('que_hint') }}</textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Hint</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                
                <input type="hidden" name="que_type" value="single">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <input class="mdc-text-field__input"  name="option_1" id="option_1" value="{{ old('option_1') }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Option 1</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                    
                  </div>
                  
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="option_2" id="option_2" value="{{ old('option_2') }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Option 2</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="option_3" id="option_3" value="{{ old('option_3') }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Option 3</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="option_4" id="option_4" value="{{ old('option_4') }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Option 4</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                  <select class="mdc-text-field__input dynamic" name="correct_ans" id="correct_ans" value="{{ old('correct_ans') }}">
                  <option value=""></option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select>
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Correct Answer</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                  {{-- //course name --}}
                  <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="que_mark" id="que_mark" value="{{ old('que_mark') }}">
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
                       Add Question
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
