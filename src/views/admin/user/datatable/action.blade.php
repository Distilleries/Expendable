@if (PermissionUtil::hasAccess($route . 'getView'))
    <a href="{{ action($route . 'getView', $data['id']) }}" class="btn btn-sm blue-steel filter-submit margin-bottom">
        <i class="fa fa-file-text-o"></i>
        {{ trans('datatable-builder::datatable.view') }}
    </a>
@endif

@if (PermissionUtil::hasAccess($route . 'getEdit'))
    <a href="{{ action($route . 'getEdit', $data['id']) }}" class="btn btn-sm yellow filter-submit margin-bottom">
        <i class="fa fa-edit"></i>
        {{ trans('datatable-builder::datatable.edit') }}
    </a>
@endif

@if (config('expendable.auth.security_enabled') === true)
    @if ($data['nb_of_try'] >= config('expendable.auth.nb_of_try'))
        @if (PermissionUtil::hasAccess($route . 'postUnLock'))
            {!! Form::open(['url' => action($route . 'postUnLock'), 'method' => 'post', 'class'=>'form-inline']) !!}
                {!! Form::hidden('id', $data['id']) !!}
                {!! Form::button('<i class="fa fa-unlock"></i> ' . trans('expendable::datatable.unlock'), [
                    'type' => 'submit',
                    'class' => 'btn btn-sm green-jungle filter-submit margin-bottom',
                ]) !!}
            {!! Form::close() !!}
        @endif
    @else
        @if (PermissionUtil::hasAccess($route . 'postLock'))
            {!! Form::open(['url' => action($route . 'postLock'), 'method' => 'post', 'class'=>'form-inline']) !!}
                {!! Form::hidden('id', $data['id']) !!}
                {!! Form::button('<i class="fa fa-lock"></i> ' . trans('expendable::datatable.lock'), [
                    'type' => 'submit',
                    'class' => 'btn btn-sm red-intense filter-submit margin-bottom',
                ]) !!}
            {!! Form::close() !!}
        @endif
    @endif
@endif

@if (PermissionUtil::hasAccess($route . 'putDestroy'))
    {!! Form::open(['url' => action($route . 'putDestroy'), 'method' => 'put', 'class' => 'form-inline']) !!}
        {!! Form::hidden('id', $data['id']) !!}
        {!! Form::button('<i class="fa fa-trash-o"></i> ' . trans('datatable-builder::datatable.remove'), [
            'type' => 'submit',
            'class' => 'btn btn-sm red filter-submit margin-bottom',
            'data-title' => trans('datatable-builder::datatable.are_you_sure'),
            'data-toggle' => 'confirmation',
            'data-placement' => 'right',
            'data-singleton' => 'true',
            'data-btn-ok-label' => trans('datatable-builder::datatable.yes'),
            'data-btn-cancel-label' => trans('datatable-builder::datatable.no'),
        ]) !!}
    {!! Form::close() !!}
@endif