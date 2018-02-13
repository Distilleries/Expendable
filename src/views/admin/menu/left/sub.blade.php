<ul class="sub-menu">
    @foreach ($item['submenu'] as $subItem)
        @if (PermissionUtil::hasAccess($subItem['action']))
            <li class="{{ (isset($subItem['action']) and (strpos(stripcslashes(json_encode($subItem)), Route::current()->getActionName()) !== false)) ? 'active' : '' }}">
                <a href="{{ ! empty($subItem['action']) ? action($subItem['action']) : 'javascript;' }}">
                    @if ($item['icon'])
                        <i class="glyphicon glyphicon-{{ $subItem['icon'] }}"></i>
                    @endif
                    {{ trans($subItem['libelle'], ['component' => trans($item['libelle'])]) }}
                    @if (! empty($subItem['submenu']))
                        @if (isset($subItem['action']) and (strpos($subItem['action'],$controller) !== false))
                            <span class="selected"></span>
                            <span class="arrow open"></span>
                        @else
                            <span class="arrow"></span>
                        @endif
                    @endif
                </a>
                @if (! empty($subItem['submenu']))
                    @include('expendable::admin.menu.left.sub', ['item' => $subItem, 'controller' => $controller])
                @endif
            </li>
        @endif
    @endforeach
</ul>