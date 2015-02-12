@section('content')
    @yield('state.menu')
    <div class="row">
        <div class="col-md-12">
            @include('expendable::admin.form.partial.errors')
            @yield('datatable')
        </div>
    </div>
@stop