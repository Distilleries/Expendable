@section('content')
    @yield('state.menu')
    <div class="row">
        <div class="col-md-12">
            @include('expendable::admin.form.partial.errors')
            <div class="tabbable tabbable-custom boxless tabbable-reversed">
                @yield('form')
            </div>
        </div>
    </div>
@stop