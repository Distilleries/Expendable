@section('footer')
<div class="copyright">
</div>
<div class="scroll-to-top">
    <i class="glyphicon glyphicon-upload"></i>
</div>

{!! HTML::script('assets/admin/js/app.admin.min.js?v='.$version) !!}
@include('expendable::admin.part.validation')
@yield('javascript')
@stop