@section('content')
	<div class="row">
		<div class="col-md-12 {{ $class }}">
			<div class="number">
				 {{ $code }}
			</div>
			<div class=" details">
				<h3>{{ trans('expendable::errors.oops') }}</h3>
				@if (config('app.debug'))
					<p>{{ $message }}</p>
				@else
					<p>
						{{ trans('expendable::errors.fixing_it') }}<br>
						{{ trans('expendable::errors.come_back_later') }}<br><br>
					</p>
				@endif
			</div>
		</div>
	</div>
@stop