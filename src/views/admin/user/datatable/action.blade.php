<a href="{{ action($route.'getView',$data['id']) }}" class="btn btn-sm blue filter-submit margin-bottom"><i
            class="glyphicon glyphicon-edit"></i> {{trans('datatable-builder::datatable.view')}}</a>
<a href="{{ action($route.'getEdit',$data['id']) }}" class="btn btn-sm yellow filter-submit margin-bottom"><i
            class="glyphicon glyphicon-edit"></i> {{trans('datatable-builder::datatable.edit')}}</a>

@if(config('expendable.auth.security_enabled') === true)
    @if($data['nb_of_try'] >= 5)

        {!! Form::open([
        'url' => action($route.'postUnLock'),
        'method' => 'post',
        'class'=>'form-inline']) !!}
        {!! Form::hidden('id',$data['id']) !!}
        {!! Form::button('<i class="fa fa-unlock"></i> '.trans('expendable::datatable.unlock'),[
        "type"=>"submit",
        "class"=>"btn btn-sm green filter-submit margin-bottom",
        ]) !!}
        {!! Form::close() !!}
    @else

        {!! Form::open([
        'url' => action($route.'postLock'),
        'method' => 'post',
        'class'=>'form-inline']) !!}
        {!! Form::hidden('id',$data['id']) !!}
        {!! Form::button('<i class="fa fa-lock"></i> '.trans('expendable::datatable.lock'),[
        "type"=>"submit",
        "class"=>"btn btn-sm purple filter-submit margin-bottom",
        ]) !!}
        {!! Form::close() !!}
    @endif
@endif



{!! Form::open([
'url' => action($route.'putDestroy'),
'method' => 'put',
'class'=>'form-inline']) !!}
{!! Form::hidden('id',$data['id']) !!}
{!! Form::button('<i class="glyphicon glyphicon-trash"></i> '.trans('datatable-builder::datatable.remove'),[
"type"=>"submit",
"data-toggle"=>"confirmation",
"data-placement"=>"right",
"data-singleton"=>"true",
"data-btn-cancel-label"=>trans('datatable-builder::datatable.no'),
"data-btn-ok-label"=>trans('datatable-builder::datatable.yes'),
"data-title"=>trans('datatable-builder::datatable.are_you_sure'),
"class"=>"btn btn-sm red filter-submit margin-bottom",
]) !!}
{!! Form::close() !!}