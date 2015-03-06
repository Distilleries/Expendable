@section('content')
    {!! form_start($form) !!}
        <h3 class="form-title">{{ trans('expendable::form.forgot_password') }}</h3>
        @include('expendable::admin.form.partial.errors')
        <p>{{trans('expendable::form.enter_your_email_below_to_reset_your_password')}}</p>
        <div class="form-group">
            {!! form_label($form->email,['class'=>'control-label visible-ie8 visible-ie9']) !!}
            <div class="input-icon">
                <i class="glyphicon glyphicon-user"></i>
                {!! form_widget($form->email) !!}
            </div>
        </div>
        <div class="form-actions">
            {!! form_widget($form->send) !!}
		</div>
	{!! form_end($form) !!}
@stop
