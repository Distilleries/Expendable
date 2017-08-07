<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{ app()->getLocale() }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="{{ app()->getLocale() }}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    @yield('header')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="{{ ! empty($class_layout) ? $class_layout : 'page-quick-sidebar-over-content page-sidebar-closed' }}">
   <div class="clearfix"></div>
   <div class="page-container">
        @yield('content')
   </div>
</body>
@yield('footer')
<!-- END BODY -->
</html>