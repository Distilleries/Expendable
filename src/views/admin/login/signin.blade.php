@section('content')
    {!! form_start($form) !!}
        <h3 class="form-title">{{trans('expendable::form.login_to_your_account')}}</h3>
        @include('expendable::admin.form.partial.errors')
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            {!! form_label($form->email,['class'=>'control-label visible-ie8 visible-ie9']) !!}
            <div class="input-icon">
                <i class="glyphicon glyphicon-user"></i>
                {!! form_widget($form->email) !!}
            </div>
        </div>
        <div class="form-group">
            {!! form_label($form->password,['class'=>'control-label visible-ie8 visible-ie9']) !!}
            <div class="input-icon">
                <i class="glyphicon glyphicon-lock"></i>
               {!! form_widget($form->password) !!}
            </div>
        </div>
        <div class="form-actions">
            {!! form_widget($form->login) !!}
		</div>
		<div class="forget-password">
			<h4>{{trans('expendable::form.forgot_your_password')}}</h4>
			<p>{!! trans('expendable::form.click_here_to_reset_your_password',['link'=>route('login.remind')]) !!}</p>
		</div>
	{!! form_end($form) !!}
@stop
