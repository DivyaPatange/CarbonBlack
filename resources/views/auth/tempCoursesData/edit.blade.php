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
@if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
  <div class="mdc-layout-grid__inner mt-5">
    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
      <div class="mdc-card p-0">
        <h6 class="card-title card-padding pb-0" style="display:inline-block;"><b>Add Course</b></h6>
        <form action="{{ route('tempCoursesData.update', $tempcourses->id) }}" enctype="multipart/form-data" method="post">
          
          <div class="mdc-card">
           @method('PUT')
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="template-demo">
              <div class="mdc-layout-grid__inner">
                {{-- course title --}}
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Course Title</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="title" id="course_title" value="{{ $tempcourses->title }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Course Title</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                  {{-- //course title --}}

                  {{-- courses image --}}
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Course Image</p>
                  <p class="card-text">Add an image to represent this course. This will appear as course title</p>
                  <p class="card-text">
                  @if($tempcourses->img)
                    <a href="{{ URL::to('/') }}/courseImg/{{$tempcourses->img}}" target="_blank"> Click to view</a>
                  @endif
                  <input type="hidden" name="hidden_image" value="{{$tempcourses->img}}">
                  </p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-8-desktop">
                <div class="form-group files">
                <input type="file" class="form-control" multiple="" id="coverImage" name="img">
              </div>
                </div>
                {{-- //courses image --}}
                {{-- course category --}}
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Course category</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <select class="mdc-text-field__input" name="category" id="category">
                      @foreach($coursetab ?? '' as $key => $c)
                        <option value="{{ $c->name }}" {{ ($c->name == $tempcourses->category) ? 'selected=selected' : '' }}>{{ $c->name }}</option>
                      @endforeach
                    </select>
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Course Category</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                  {{-- //course category --}}

                {{-- courses description --}}
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Brief Description</p>
                  <p class="card-text">This appears on course card</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <textarea class="mdc-text-field__input" rows="5" name="description" id="description">{{ $tempcourses->description }}</textarea> 
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Write Description Here</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                {{-- //courses description --}}

                {{-- courses path --}}
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-4-desktop">
                  <p class="card-title">Course path</p>
                </div>
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-8-desktop">
                  <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                    <input class="mdc-text-field__input"  name="path" id="course_path" value="{{ $tempcourses->path }}">
                    <div class="mdc-notched-outline">
                      <div class="mdc-notched-outline__leading"></div>
                      <div class="mdc-notched-outline__notch">
                        <label class="mdc-floating-label">Course Path</label>
                      </div>
                      <div class="mdc-notched-outline__trailing"></div>
                    </div>
                  </div>
                </div>
                {{-- //courses path --}}
                
                <div class="mdc-layout-grid__cell stretch-card1 mdc-layout-grid__cell--span-12-desktop text-center">
                <button class="mdc-button mdc-button--unelevated filled-button--success mdc-ripple-upgraded" style="--mdc-ripple-fg-size:56px; --mdc-ripple-fg-scale:1.96936; --mdc-ripple-fg-translate-start:6px, -0.200012px; --mdc-ripple-fg-translate-end:18.8px, -10px;" type="submit" name="submit">
                        Update Course
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
