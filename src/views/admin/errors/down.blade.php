<!DOCTYPE html>
<!--[if IE 8]> <html lang="{{ app()->getLocale() }}" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="{{ app()->getLocale() }}" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="/favicon.ico">
	<base href="{{ Config::get('app.url') }}">
	{{ HTML::style('assets/css/app.admin.min.css?v=' . rand()); }}
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-404-full-page">
   <div class="clearfix"></div>
   <div class="page-container">
	   <div class="row">
           	<div class="col-md-12 page-404">
           		<div class="number">
           			 {{ $code }}
           		</div>
           		<div class="details">
           			<h3>{{ trans('expendable::errors.oops') }}</h3>
           			<p>{{ trans('expendable::errors.be_right_back') }}</p>
           		</div>
           	</div>
        </div>
   </div>
   <div class="copyright"></div>
</body>
</html>