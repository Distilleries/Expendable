<ul class="list-unstyled list-inline">
    @foreach ($languages as $language)
        <li>
            @if (in_array($language->iso, array_keys(is_array($translations) ? $translations : $translations->toArray())))
                @if (PermissionUtil::hasAccess($route . 'getEdit'))
                    <a href="{{ action($route . 'getEdit', $translations[$language->iso]) }}" class="edit-flag-link">
                        <i class="glyphicon glyphicon-pencil"></i>
                        <br><span class="flags-sprite flags-{{ $language->iso }}"></span>
                    </a>
                @endif
            @else
                @if (PermissionUtil::hasAccess($route . 'getTranslation'))
                    <a href="{{ action($route . 'getTranslation', [$language->iso,$data['id']]) }}" class="edit-flag-link">
                        <span class="flags-sprite flags-{{ $language->iso }}"></span>
                    </a>
                @endif
            @endif
        </li>
    @endforeach
</ul>
