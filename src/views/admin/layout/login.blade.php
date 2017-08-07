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
<body class="{{ ! empty($class_layout) ? $class_layout : '' }}">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="/">
            <img src="{{ asset('assets/backend/images/logo.jpg') }}" alt="">
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        @yield('content')
   </div>
    <!-- END LOGIN -->
    @yield('footer')
</body>
<!-- END BODY -->
</html>