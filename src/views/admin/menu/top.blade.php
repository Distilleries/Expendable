@section('menu_top')
    <div class="page-header navbar">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/">
                    <img src="{{ asset('assets/backend/images/logo.jpg') }}" alt="" class="logo-default" height="24">
                </a>
                <div class="menu-toggler sidebar-toggler hide"></div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    @if (! empty($languages))
                        <li class="dropdown dropdown-extended dropdown-notification">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <?php $iso = app()->getLocale(); ?>
                                <span class="flags-sprite flags-{{ $iso }}"></span>
                                <span class="badge badge-grey">{{ count($languages) }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($languages as $language)
                                    <?php
                                    $iso = explode('_', $language['iso']);
                                    $iso = isset($iso[1]) ? strtolower($iso[1]) : strtolower($iso[0]);
                                    ?>
                                    <li>
                                        <a href="{{ config('expendable.admin_base_uri') }}/set-lang/{{$language['iso']}}">
                                            <span class="details">
                                                <span class="flags-sprite flags-{{ $iso }}"></span>
                                                {{ $language['libelle'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    <?php $tasks = config('expendable.menu.tasks'); ?>
                    @if (! empty($tasks) and PermissionUtil::hasAccessArray($tasks, false, 'action'))
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="glyphicon glyphicon-tasks"></i>
                                <span class="badge badge-default">{{ count($tasks) }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($tasks as $task)
                                     @if (PermissionUtil::hasAccess($task['action']))
                                        <li>
                                            <a href="{{ action($task['action']) }}" target="_blank">
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="glyphicon glyphicon-{{ $task['icon'] }}"></i>
                                                    </span>
                                                    {{ trans($task['libelle']) }}
                                                </span>
                                            </a>
                                        </li>
                                     @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{ forxer\Gravatar\Gravatar::image(\Distilleries\Expendable\Helpers\UserUtils::getEmail()) }}">
                            <span class="username username-hide-on-mobile">{{ Distilleries\Expendable\Helpers\UserUtils::getDisplayName() }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ route('user.profile') }}">
                                    <i class="icon-user"></i> {{ trans('expendable::menu.my_profile') }}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('login.logout') }}">
                                    <i class="icon-key"></i> {{ trans('expendable::menu.log_out') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
@stop