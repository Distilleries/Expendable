@section('content')
    {!! form_start($form) !!}
        <h3 class="form-title">{{trans('expendable::form.reset_your_password')}}</h3>
        @include('expendable::admin.form.partial.errors')
         {!! form_widget($form->token) !!}
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
        <div class="form-group">
              {!! form_label($form->password_confirmation,['class'=>'control-label visible-ie8 visible-ie9']) !!}
              <div class="input-icon">
                  <i class="glyphicon glyphicon-lock"></i>
                 {!! form_widget($form->password_confirmation) !!}
              </div>
        </div>
        <div class="form-actions">
            {!! form_widget($form->send) !!}
		</div>
	{!! form_end($form) !!}
@stop