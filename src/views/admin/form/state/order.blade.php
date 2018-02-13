@section('content')
    <style>
        #order_table_body tr {
            cursor: ns-resize;
            vertical-align: middle;
        }
    </style>
    @yield('state.menu')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-arrows-v"></i>
                        {{ trans('expendable::datatable.order') }}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="20"></th>
                                    <th>{{ trans('expendable::datatable.label') }}</th>
                                </tr>
                            </thead>
                            <tbody id="order_table_body">
                                @foreach ($rows as $row)
                                    <tr data-id="{{ $row->getKey() }}">
                                        <td width="20"><img src="/assets/backend/images/order_icon.png" alt=""></td>
                                        <td>{!! $row->orderLabel() !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {
            function getOrderedIds() {
                var ids = [];

                $('#order_table_body tr').each(function () {
                    ids.push($(this).data('id'));
                });

                return ids;
            }

            function postOrderedRows(ids) {
                $.ajax({
                    url: this.document.location,
                    type: 'POST',
                    data: {
                        ids: ids
                    },
                    success: function (response) {
                        if (response.error) {
                            alert('An error occured while saving current order!');
                        }
                    }
                });
            }

            Sortable.create(document.getElementById('order_table_body'), {
                onUpdate: function (event) {
                    var ids = getOrderedIds();
                    postOrderedRows(ids);
                }
            });
        });
    </script>
@endsection