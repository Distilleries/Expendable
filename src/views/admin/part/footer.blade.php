@section('footer')
<div class="copyright">
</div>
<div class="scroll-to-top">
    <i class="glyphicon glyphicon-upload"></i>
</div>

<script src="{{ elixir('js/all.js','assets/backend/build') }}"></script>
@include('expendable::admin.part.validation')
@yield('javascript')
@stop