@section('content')
    {{ form_start($form) }}
        <h3 class="form-title">{{ _('Login to your account') }}</h3>
        @include('expendable::admin.form.partial.errors')
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            {{ form_label($form->email,['class'=>'control-label visible-ie8 visible-ie9']) }}
            <div class="input-icon">
                <i class="glyphicon glyphicon-user"></i>
                {{ form_widget($form->email) }}
            </div>
        </div>
        <div class="form-group">
            {{ form_label($form->password,['class'=>'control-label visible-ie8 visible-ie9']) }}
            <div class="input-icon">
                <i class="glyphicon glyphicon-lock"></i>
               {{ form_widget($form->password) }}
            </div>
        </div>
        <div class="form-actions">
            {{ form_widget($form->login) }}
		</div>
		<div class="forget-password">
			<h4>{{ _('Forgot your password ?') }}</h4>
			<p>{{ sprintf(_(' no worries, click <a href="%s" >here</a> to reset your password.'),route('login.remind')) }}</p>
		</div>
	{{ form_end($form) }}
@stop
