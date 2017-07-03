@section('footer')
<div class="copyright">
</div>
<div class="scroll-to-top">
    <i class="glyphicon glyphicon-upload"></i>
</div>

<script src="{{ asset(mix('assets/backend/script.js')) }}" ></script>
<script src="{{ asset(mix('assets/backend/app.js')) }}" ></script>
@include('expendable::admin.part.validation')
@yield('javascript')
@stop