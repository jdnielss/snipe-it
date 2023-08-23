@extends('layouts/default')
{{-- Page title --}}
@section('title') Document @parent

@stop

@section('header_right')

    <!-- @can('create', \App\Models\Document::class) -->
        <a href="{{ route('document.create') }}" accesskey="n" class="btn btn-primary pull-right" style="margin-right: 5px;">  {{ trans('general.create') }}</a>
    <!-- @endcan -->
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
        <div class="box-body">
            <table
                    data-click-to-select="true"
                    data-columns="{{ \App\Presenters\DocumentPresenter::dataTableLayout() }}"
                    data-cookie-id-table="documentTable"
                    data-pagination="true"
                    data-id-table="documentTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-fullscreen="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="documentTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.document.list') }}">
                    </table>
                    {{ Form::close() }}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

@stop

@section('moar_scripts')


@include ('partials.bootstrap-table')


@stop