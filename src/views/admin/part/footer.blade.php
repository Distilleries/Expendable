@section('footer')
    <div class="copyright"></div>
    <div class="scroll-to-top">
        <i class="glyphicon glyphicon-upload"></i>
    </div>
    @if (app()->environment() !== 'testing')
        <script src="{{ asset(mix('assets/backend/scripts.js')) }}"></script>
        <script src="{{ asset(mix('assets/backend/app.js')) }}"></script>
    @endif
    @include('expendable::admin.part.validation')
@stop