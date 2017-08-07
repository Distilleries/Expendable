<?php
$action = isset($item['action']) ? preg_replace('/index/i', '', action($item['action'])) : '';
$controller = preg_split('/@/', Route::current()->getActionName());
$controller = is_array($controller) ? $controller[0] : $controller;
?>
@if (PermissionUtil::hasAccess($item['action']))
    <li class="{{ ($key == 0) ? 'start' : ''}} {{ ($key === (count($items) - 1)) ? 'last' : '' }} {{ isset($item['action']) ? ((strpos(stripcslashes(json_encode($item)), $controller) !== false) ? 'active' : '') : '' }}">
        <a href="{{ ! empty($item['action']) ? $action : 'javascript;' }}">
            @if ($item['icon'])
                <i class="glyphicon glyphicon-{{ $item['icon'] }}"></i>
            @endif
            <span class="title">{{ trans($item['libelle']) }}</span>

            @if (! empty($item['submenu']))
                @if (isset($item['action']) and (strpos($item['action'], $controller) !== false))
                    <span class="selected"></span>
                    <span class="arrow open"></span>
                @else
                    <span class="arrow"></span>
                @endif
            @endif
        </a>
        @if (! empty($item['submenu']))
            @include('expendable::admin.menu.left.sub', ['item' => $item, 'controller' => $controller])
        @endif
    </li>
@endif