<header class="mdc-top-app-bar">
        <div class="mdc-top-app-bar__row">
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler"><i class="mdi mdi-menu" aria-hidden="true"></i></button>
           
          </div>
          <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
            <div class="menu-button-container menu-profile d-none d-md-block">
              <button class="mdc-button mdc-menu-button">
                <span class="d-flex align-items-center">
                  <!--<span class="figure">-->
                  <!--  <img src="{{ asset('brandAssets/images/faces/face1.jpg') }}" alt="user" class="user">-->
                  <!--</span>-->
                  <span class="user-name">{{Auth::user()->name}}</span>
                </span>
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  @if(Auth::user()->acc_type == 'admin')
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-account-edit-outline text-primary"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <a href="{{ url('/editProfile') }}"<h6 class="item-subject font-weight-normal">Edit Profile</h6></a>
                    </div>
                  </li>
                  @endif
                    @if(Auth::user()->acc_type == 'user')
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-account-edit-outline text-primary"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <a href="{{ url('/changePassword') }}"<h6 class="item-subject font-weight-normal">Change Password</h6></a>
                    </div>
                  </li>
                  @endif
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon-only">
                      <i class="mdi mdi-settings-outline text-primary"></i>                      
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><h6 class="item-subject font-weight-normal">Logout</h6></a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                      </form>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <div class="divider d-none d-md-block"></div>
            <!--<div class="menu-button-container d-none d-md-block">-->
            <!--  <button class="mdc-button mdc-menu-button">-->
            <!--    <i class="mdi mdi-settings"></i>-->
            <!--  </button>-->
            <!--  <div class="mdc-menu mdc-menu-surface" tabindex="-1">-->
            <!--    <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail item-thumbnail-icon-only">-->
            <!--          <i class="mdi mdi-alert-circle-outline text-primary"></i>-->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Settings</h6>-->
            <!--        </div>-->
            <!--      </li>-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail item-thumbnail-icon-only">-->
            <!--          <i class="mdi mdi-progress-download text-primary"></i>                      -->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Update</h6>-->
            <!--        </div>-->
            <!--      </li>-->
            <!--    </ul>-->
            <!--  </div>-->
            <!--</div>-->
            <div class="menu-button-container">
            @can('manage-users')
            <div class="menu-button-container">
              <button class="mdc-button mdc-menu-button">
                <i class="mdi mdi-bell"></i>
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <h6 class="title"> <i class="mdi mdi-bell-outline mr-2 tx-16"></i> Notifications</h6>
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-account-outline"></i>                      
                    </div>
                    
                    <?php
                        if(Auth::user()->acc_type == "superadmin")
                        {
                            $user = DB::table('users')->where('date', date("Y-m-d"))->get();
                            // dd($user);
                        }
                        else{
                            $user = DB::table('users')->where('parent_id', Auth::user()->id)->where('date', date("Y-m-d"))->get();
                        }
                    ?>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">Today's Registered User <span class="badge badge-danger" style="border-radius:50%">{{ count($user) }}</span></h6>
                    </div>
                  </li>
                </ul>
              </div> 
            </div>
            @endcan
              <!-- <button class="mdc-button mdc-menu-button">
                <i class="mdi mdi-bell"></i>
              </button>
              <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                <h6 class="title"> <i class="mdi mdi-bell-outline mr-2 tx-16"></i> Notifications</h6>
                <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-email-outline"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">You received a new message</h6>
                      <small class="text-muted"> 6 min ago </small>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-account-outline"></i>                      
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">New user registered</h6>
                      <small class="text-muted"> 15 min ago </small>
                    </div>
                  </li>
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-alert-circle-outline"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">System Alert</h6>
                      <small class="text-muted"> 2 days ago </small>
                    </div>
                  </li> 
                  <li class="mdc-list-item" role="menuitem">
                    <div class="item-thumbnail item-thumbnail-icon">
                      <i class="mdi mdi-update"></i>
                    </div>
                    <div class="item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="item-subject font-weight-normal">You have a new update</h6>
                      <small class="text-muted"> 3 days ago </small>
                    </div>
                  </li> 
                </ul>
              </div> -->
            </div>
            <!--<div class="menu-button-container">-->
            <!--  <button class="mdc-button mdc-menu-button">-->
            <!--    <i class="mdi mdi-email"></i>-->
            <!--    <span class="count-indicator">-->
            <!--      <span class="count">3</span>-->
            <!--    </span>-->
            <!--  </button>-->
            <!--  <div class="mdc-menu mdc-menu-surface" tabindex="-1">-->
            <!--    <h6 class="title"><i class="mdi mdi-email-outline mr-2 tx-16"></i> Messages</h6>-->
            <!--    <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail">-->
            <!--          <img src="../assets/images/faces/face4.jpg" alt="user">-->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Mark send you a message</h6>-->
            <!--          <small class="text-muted"> 1 Minutes ago </small>-->
            <!--        </div>-->
            <!--      </li>-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail">-->
            <!--          <img src="../assets/images/faces/face2.jpg" alt="user">-->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Cregh send you a message</h6>-->
            <!--          <small class="text-muted"> 15 Minutes ago </small>-->
            <!--        </div>-->
            <!--      </li>-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail">-->
            <!--          <img src="../assets/images/faces/face3.jpg" alt="user">-->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Profile picture updated</h6>-->
            <!--          <small class="text-muted"> 18 Minutes ago </small>-->
            <!--        </div>-->
            <!--      </li>                -->
            <!--    </ul>-->
            <!--  </div>-->
            <!--</div>-->
            <!--<div class="menu-button-container d-none d-md-block">-->
            <!--  <button class="mdc-button mdc-menu-button">-->
            <!--    <i class="mdi mdi-arrow-down-bold-box"></i>-->
            <!--  </button>-->
            <!--  <div class="mdc-menu mdc-menu-surface" tabindex="-1">-->
            <!--    <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail item-thumbnail-icon-only">-->
            <!--          <i class="mdi mdi-lock-outline text-primary"></i>-->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Lock screen</h6>-->
            <!--        </div>-->
            <!--      </li>-->
            <!--      <li class="mdc-list-item" role="menuitem">-->
            <!--        <div class="item-thumbnail item-thumbnail-icon-only">-->
            <!--          <i class="mdi mdi-logout-variant text-primary"></i>                      -->
            <!--        </div>-->
            <!--        <div class="item-content d-flex align-items-start flex-column justify-content-center">-->
            <!--          <h6 class="item-subject font-weight-normal">Logout</h6>-->
            <!--        </div>-->
            <!--      </li>-->
            <!--    </ul>-->
            <!--  </div>-->
            <!--</div>-->
          </div>
        </div>
      </header>