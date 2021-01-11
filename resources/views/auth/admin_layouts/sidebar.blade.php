
<!-- partial:partials/_sidebar.html -->
<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open" style="background: #000;">
      <div class="mdc-drawer__header" style="display:flex;">
         <a href="{{ url('/home') }}" class="brand-logo">
          @can('manage-admin-user')<img src="{{ URL::asset('assets/frontend/img/logo/logo.png') }}" alt="logo" class="img-fluid" style="height:50px;">@endcan
          @can('admin')
          <?php
              $user = DB::table('users')->where('id', Auth::user()->id)->first();
              // dd($user);
              $logo = DB::table('company_logo')->where('user_id', $user->id)->first();
          ?>
          @if(!empty($logo))
          <img src="{{ URL::to('/') }}/logo/{{$logo->logo}}" style="height:50px; margin:10px;">
          @endif
          @endcan
          @can('manage-user')
          <?php
              $employee = DB::table('users')->where('id', Auth::user()->id)->first();
              // dd($employee);
              $logo1 = DB::table('company_logo')->where('user_id', $employee->parent_id)->first();
          ?>
          @if(!empty($logo1))
          <img src="{{ URL::to('/') }}/logo/{{$logo1->logo}}" style="height:50px; margin:10px;">
          @endif
          @endcan
        </a>
          <h6 class="text-light" style="padding-top:37px;">Carbon Black <br> <span>Education</span></h6>
        
      </div>
      <div class="mdc-drawer__content">
        <!--<div class="user-info">-->
          {{-- <p class="name">{{Auth::user()->name}}</p> --}}
          {{-- <p class="email">{{Auth::user()->email}}</p> --}}
        <!--</div>-->
        <div class="mdc-list-group">
          <nav class="mdc-list mdc-drawer-menu">
            <!--<div class="mdc-list-item mdc-drawer-item">-->
            <!--  <a class="mdc-drawer-link" href="/home">-->
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">home</i>-->
            <!--    <i class="mdi mdi-home mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>-->
            <!--    Getting Started-->
            <!--  </a>-->
            <!--</div>-->
            @can('manage-users')
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('users') }}">
                 <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>-->
                 <i class="mdi mdi-account mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Users
              </a>
            </div>
            @endcan
            
            @can('manage-admin-user')
            @php
              $user = DB::table('users')->where('parent_id', '=', 1)->get();
            @endphp
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#" data-toggle="expansionPanel" data-target="sample-page-submenu">
                 <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">dashboard</i>-->
                 <i class="mdi mdi-account mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Administrator List
              </a>

              <div class="mdc-expansion-panel" id="sample-page-submenu">
                <nav class="mdc-list mdc-drawer-submenu">
                @foreach($user as $u)
                  <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="{{ route('users.list', $u->id) }}">
                      {{$u->name}}
                    </a>
                  </div>
                @endforeach
                </nav>
                </div>
            </div>
            @endcan
            @can('manage-admin-user')
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('tempCoursesData.coursesAll') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-page-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Courses
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('test.index') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Create Test
              </a>
            </div>
            
            @endcan
            @can('manage-admin-users')
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('tempCoursesData.index') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-folder-multiple-outline mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Courses
              </a>
            </div>
            
            @endcan
            @can('admin')
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('user.test.index') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-page-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Test
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('user.moduleReactivate.request') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-page-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Module Reactivate
              </a>
            </div>
            @endcan
            @can('manage-user')
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('take.test') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-page-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Take Test
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('user.certificate') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Certification
              </a>
            </div>
            @endcan
            @can('manage-users')
            
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="{{ route('admin.test.result') }}">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-page-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Test Result
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book-open-page-variant mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Learning Plans
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-book mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Certification
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-bookmark-plus-outline mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Job Aids
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
                <h6 class="text-muted">MANAGE</h6>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-folder-outline mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                My Courses
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-library mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Content Library
              </a>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
                <h6 class="text-muted">VIEW</h6>
            </div>
            <div class="mdc-list-item mdc-drawer-item">
              <a class="mdc-drawer-link" href="#">
                <!--<i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon" aria-hidden="true">description</i>-->
                <i class="mdi mdi-bell-outline mdc-drawer-item-icon mdc-list-item__start-detail" aria-hidden="true"></i>
                Notifications
              </a>
            </div>
            @endcan
           
          </nav>
        </div>
        <!-- <div class="profile-actions">
          <a href="javascript:;">Settings</a>
          <span class="divider"></span>
          <a href="javascript:;">Logout</a>
        </div> -->
        
      </div>
    </aside>