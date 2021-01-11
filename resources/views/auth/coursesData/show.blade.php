@extends('auth.admin_layouts.main')

@section('title','Courses')

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
@endsection

@section('content')
<div class="mdc-layout-grid">
  <div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0" style="display:inline-block;">Add Course</h6>
        <form action="{{ route('coursesData.store') }}" enctype="multipart/form-data" method="post">
          <div class="mdc-card">
          @csrf
            <div class="template-demo">
              <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Course Name</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="course_name" id="course_name">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Course Name</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Brief Description</p>
                  <p class="card-text">This appears on course card</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <textarea class="mdc-text-field__input" rows="5" name="description" id="description"></textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Write Description Here</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Detailed Overview</p>
                  <p class="card-text">This appears on course page</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <textarea class="mdc-text-field__input" rows="5" name="overview" id="overview"></textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Write Overview Here</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop">
                  <hr>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Modules </p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-8-desktop">
                  <span>Content: *Core Modules that make up the course</span>
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <textarea class="mdc-text-field__input" rows="5" name="module[]" id="module1"></textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Add Modules</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-8-desktop">
                  <span>Prework: Helps learners prepare for the course</span>
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <textarea class="mdc-text-field__input" rows="5" name="module[]" id="module2"></textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Add Modules</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-8-desktop">
                  <span>Testout: Allows learners to skip Course content. Know more</span>
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <textarea class="mdc-text-field__input" rows="5" name="module[]" id="module3"></textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Add Modules</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Sequencing of modules </p>
                  <p class="card-text">Decide if learners must take modules in  sequential order</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                      <input type="checkbox" class="mdc-checkbox__native-control" id="sequence1" name="sequence[]" value="ordered">
                      <div class="mdc-checkbox__background">
                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                          <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                        </svg>
                        <div class="mdc-checkbox__mixedmark"></div>
                      </div>
                    </div>
                    <label>Ordered</label>
                  </div>
                  <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                      <input type="checkbox" class="mdc-checkbox__native-control" id="sequence2"  name="sequence[]" value="unordered">
                      <div class="mdc-checkbox__background">
                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                          <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                        </svg>
                        <div class="mdc-checkbox__mixedmark"></div>
                      </div>
                    </div>
                    <label>Unordered</label>
                  </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Cover Image</p>
                  <p class="card-text">Add an image to represent this course. This will appear as course title</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-8-desktop">
                <div class="form-group files">
                <input type="file" class="form-control" multiple="" id="coverImage" name="coverImage">
              </div>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Banner Image</p>
                  <p class="card-text">Add a banner image to represent this course. It will appear on course page.</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-8-desktop">
                <div class="form-group files">
                <input type="file" class="form-control" multiple="" id="bannerImage" name="bannerImage">
              </div>
              
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop text-center">
                <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                        Add Course
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
