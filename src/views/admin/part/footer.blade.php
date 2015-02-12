@section('footer')
<div class="copyright">
</div>
{{ HTML::script('assets/admin/js/app.admin.min.js?v='.$version); }}
@include('expendable::admin.part.validation')
@yield('javascript')
@stop