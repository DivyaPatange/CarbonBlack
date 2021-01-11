<!DOCTYPE html>
  <html lang="en">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E-learning @yield('title')</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">
    @include('brand_front.front_layouts.top_links')
    @yield('customcss')

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