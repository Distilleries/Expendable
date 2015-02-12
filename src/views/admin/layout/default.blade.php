<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
@yield('header')
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="{{ !empty($class_layout)?$class_layout:'page-quick-sidebar-over-content page-sidebar-closed' }}">

   @yield('menu_top')
   <div class="clearfix"></div>

   <div class="page-container">
        @yield('menu_left')
        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
   </div>
</body>

@yield('footer')
<!-- END BODY -->
</html>