@section('menu_left')
<?php $collapsed = Config::get('expendable.menu_left_collapsed'); ?>
<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapsee collapse">
			<ul class="page-sidebar-menu {{$collapsed?'page-sidebar-menu-closed':''}} "
			data-keep-expanded="{{$collapsed?'false':'true'}}"
			data-auto-scroll="true"
			data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler"></div>
				</li>

				<?php $items = Config::get('expendable.menu.left'); ?>
				@foreach($items as $key=>$item)

                    <?php $action = isset($item['action'])?preg_replace('/index/i','',action($item['action'])):''; ?>
                    <?php
                    $controller = preg_split("/@/",Route::current()->getActionName());
                    $controller = is_array($controller)?$controller[0]:$controller;
                    ?>
                    @if(PermissionUtil::hasAccess($item['action']))
				    <li class="{{ ($key == 0)?'start':''}} {{ ($key == count($items)-1)?'last':''}} {{ isset($item['action'])?(strpos($item['action'],$controller) !== false ? 'active' : ''):'' }}">
				        <a href="{{ (!empty($item['action']))?$action:'javascript;'  }}">
                            @if($item['icon'])
                                <i class="glyphicon glyphicon-{{ $item['icon'] }}"></i>
                            @endif
                            <span class="title">{{ $item['libelle']  }}</span>
                            @if (isset($item['action']) and (strpos($item['action'],$controller) !== false))
                            <span class="selected"></span>
                            <span class="arrow open "></span>
                            @else
                                <span class="arrow"></span>
                            @endif
                        </a>
                        @if(!empty($item['submenu']))
                        <ul class="sub-menu">
                            @foreach($item['submenu'] as $subItem)
                                @if(PermissionUtil::hasAccess($subItem['action']))
                                    <li class="{{ ( isset($subItem['action']) and Route::current()->getActionName() == $subItem['action'])?'active':'' }}">
                                        <a href="{{ (!empty($subItem['action']))?action($subItem['action']):'javascript;'   }}">
                                        @if($item['icon'])
                                            <i class="glyphicon glyphicon-{{ $subItem['icon'] }}"></i>
                                        @endif
                                        {{ $subItem['libelle'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
				        @endif
				    </li>
				    @endif
				@endforeach
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
@stop