<!DOCTYPE html>
  <html lang="en">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-learning @yield('title')</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">
    @include('brand_front.front_layouts.top_links')
    @yield('customcss')
<style>
.nav-menu .drop-down ul{
display: block;
    position: absolute;
    left: 0px;
    top: calc(100% - 0px);
    z-index: 99;
    opacity: 0;
    visibility: hidden;
    padding: 10px 0;
    background: #fff;
    box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
    transition: ease all 0.3s;
}
</style>
   <body>
   @include('brand_front.front_layouts.header')
 

    <!-- main section -->
    @yield('content')
    <!-- main -->

    <!-- footer -->
    @include('brand_front.front_layouts.footer')
    <!-- footer end -->
    <!-- script -->
      @include('brand_front.front_layouts.scripts')
    <!-- script end -->
    @yield('customjs')
</body>

</html>