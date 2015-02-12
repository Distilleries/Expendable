@section('content')
<div class="row">
	<div class="col-md-12 {{$class}}">
		<div class=" number">
			 {{ $code }}
		</div>
		<div class=" details">
			<h3>{{ _('Oops! Something went wrong.') }}</h3>
			@if(Config::get('app.debug'))
			<p>{{ $message }}</p>
			@else
			<p>{{ _(' We are fixing it!') }}<br/>
			{{ _('  Please come back in a while.') }}<br/><br/>
            </p>
			@endif
		</div>
	</div>
</div>
@stop