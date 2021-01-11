<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Carbon  Black | @yield('title')</title>
  <!-- plugins:css -->
  @include('auth.admin_layouts.link')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @yield('customcss')
  <style>
    @font-face
    {
   font-family: BNKGOTHL;
   src: url(public/assets/frontend/css/font/BNKGOTHL.ttf);
    }

    * {
       /*font-family: BNKGOTHL !important;*/
    }
    .mdc-drawer-link{
        padding: 0 0.5rem !important;
    }
  </style>
</head>
<body>
<script src="{{ asset('brandAssets/js/preloader.js') }}"></script>
  <div class="body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    @include('auth.admin_layouts.sidebar')
    <!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content">
      <!-- partial:partials/_navbar.html -->
      @include('auth.admin_layouts.topbar')
      <!-- partial -->
      <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
          @yield('content')
        </main>
        <!-- partial:partials/_footer.html -->
        @include('auth.admin_layouts.footer')
        <!-- partial -->
      </div>
    </div>
  </div>
  <!-- plugins:js -->
  @include('auth.admin_layouts.scripts')
  @yield('customjs')
</body>
</html> 