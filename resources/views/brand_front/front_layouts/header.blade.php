<header id="header">
    <div class="container d-flex">

      <div class="logo mr-auto">
         <a href="https://carbonblack.education/"><img src="{{ URL::asset('assets/frontend/img/logo/logo.png') }}" alt="logo" class="img-fluid" style="height:100px;"></a>
         <h1 class="text-light">Carbon Black <br> <span>Education</span></h1>
      </div>
      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="{{ url('/contact') }}">Contact Us</a></li>
          <li class="drop-down"><a href="#">Courses</a>
            <ul>
                 @foreach($coursetab ?? '' as $key => $c)

              
             
              <li><a href="{{ route('login') }}">{{ $c->name }}</a></li>
              @endforeach
            </ul>
          </li>

          <li class="get-started"><a href="{{ route('login') }}">Sign In</a></li>
        </ul>
      </nav>
      <!-- .nav-menu -->
    </div>
  </header>