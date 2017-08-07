@section('menu_left')
	<?php $collapsed = Config::get('expendable.menu_left_collapsed'); ?>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapsee collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu{{ $collapsed ? ' page-sidebar-menu-closed' : '' }}" data-keep-expanded="{{ $collapsed ? 'false' : 'true' }}" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler"></div>
				</li>
				<?php $items = config('expendable.menu.left'); ?>
				@foreach ($items as $key => $item)
                    @include('expendable::admin.menu.left.main', ['item' => $item])
				@endforeach
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
@stop