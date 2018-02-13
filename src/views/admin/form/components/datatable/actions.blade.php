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