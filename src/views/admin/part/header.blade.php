@section('header')
<meta charset="utf-8"/>
<title>{{ $title }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<link rel="shortcut icon" href="favicon.ico"/>
<base href="{{ Config::get('app.url') }}" />
{!! HTML::style('assets/admin/css/app.admin.min.css?v='.$version) !!}
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@stop