@extends('layouts/default')

@section('title0')
  {{ trans('admin/hardware/general.requestable') }}
  {{ trans('general.assets') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#assets" data-toggle="tab" title="{{ trans('general.assets') }}">{{ trans('general.assets') }}
                        <badge class="badge badge-secondary"> {{ $assets->count()}}</badge>
                    </a>               
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="assets">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="table-responsive">
                                    <table
                                        data-click-to-select="true"
                                        data-cookie-id-table="requestableAssetsListingTable"
                                        data-pagination="true"
                                        data-id-table="requestableAssetsListingTable"
                                        data-search="true"
                                        data-side-pagination="server"
                                        data-show-columns="true"
                                        data-show-export="false"
                                        data-show-footer="false"
                                        data-show-refresh="true"
                                        data-sort-order="asc"
                                        data-sort-name="name"
                                        data-toolbar="#assetsBulkEditToolbar"
                                        data-bulk-button-id="#bulkAssetEditButton"
                                        data-bulk-form-id="#assetsBulkForm"
                                        id="assetsListingTable"
                                        class="table table-striped snipe-table"
                                        data-url="{{ route('api.assets.requestable', ['requestable' => true]) }}">

                                        <thead>
                                            <tr>
                                                <th class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="true">{{ trans('general.image') }}</th>
                                                <th class="col-md-2" data-field="asset_tag" data-sortable="true" >{{ trans('general.asset_tag') }}</th>                                                
                                                <th class="col-md-2" data-field="model" data-sortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                                <th class="col-md-2" data-field="model_number" data-sortable="true">{{ trans('admin/models/table.modelnumber') }}</th>
                                                <th class="col-md-2" data-field="name" data-sortable="true">{{ trans('admin/hardware/form.name') }}</th>
                                                <th class="col-md-3" data-field="serial" data-sortable="true">{{ trans('admin/hardware/table.serial') }}</th>
                                                <th class="col-md-2" data-field="location" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                                <th class="col-md-2" data-field="status" data-sortable="true">{{ trans('admin/hardware/table.status') }}</th>
                                                <th class="col-md-2" data-field="expected_checkin" data-formatter="dateDisplayFormatter" data-sortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                                                <th class="col-md-1" data-formatter="assetRequestActionsFormatter" data-field="actions" data-sortable="false">{{ trans('table.actions') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                    </div>
                </div>
            </div>

            

            </div> <!-- .tab-content-->
        </div> <!-- .nav-tabs-custom -->
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->
@stop


@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'requested-export',
        'search' => true,
        'clientSearch' => true,
    ])


    <script nonce="{{ csrf_token() }}">

    $( "a[name='Request']").click(function(event) {
        // event.preventDefault();
        quantity = $(this).closest('td').siblings().find('input').val();
        currentUrl = $(this).attr('href');
        // $(this).attr('href', currentUrl + '?quantity=' + quantity);
        // alert($(this).attr('href'));
    });
</script>
@stop


