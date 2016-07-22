@section('footer')
<div class="copyright">
</div>
<div class="scroll-to-top">
    <i class="glyphicon glyphicon-upload"></i>
</div>

<script src="/assets/backend/js/all.js?v={{ rand() }}"></script>
@include('expendable::admin.part.validation')
@yield('javascript')
@stop