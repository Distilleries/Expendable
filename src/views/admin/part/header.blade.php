@section('header')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $title }}</title>
    <base href="{{ Config::get('app.url') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @if (app()->environment() !== 'testing')
        <link href="{{ asset(mix('assets/backend/app.css')) }}" rel="stylesheet">
    @endif
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
@stop