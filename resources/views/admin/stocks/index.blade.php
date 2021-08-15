@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('stocks')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('stocks')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.stocks.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option value="product_id" {{ request("filter_by") == "product_id" ? "selected":null }}>{{ trans('product_id') }}</option>
                                            <option value="product_name" {{ request("filter_by") == "product_name" ? "selected":null }}>{{ trans('product_name') }}</option>
                                            <option value="branch_id" {{ request("filter_by") == "branch_id" ? "selected":null }}>{{ trans('branch_id') }}</option>
                                            <option value="vendor_id" {{ request("filter_by") == "vendor_id" ? "selected":null }}>{{ trans('vendor_id') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("q") }}" name="q" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control dateFrom" value="{{ request("from_date") }}" name="from_date" >
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_date") }}" name="to_date" >
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 mb-0">{{ trans("search") }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    <a href="{{route('admin.stocks.export', array_merge(request()->all(['filter_by','q','from_date','to_date'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", Stock::class)
                                    <a href="{{ route('admin.stocks.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('stocks_list')}}</h4>
                            </div>

                            <div class="card-body">
                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                        <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>×</span>
                                            </button>
                                            <div class="alert-title">{{trans('success')}}</div>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 1px">#</th>
                                                <th>{{ trans('product') }}</th>
                                                <th>{{ trans('in_amount') }}</th>
                                                <th>{{ trans('out_amount') }}</th>
                                                <th>{{ trans('balance') }}</th>
                                                <th>{{ trans('branch') }}</th>
                                                <th>{{ trans('vendor') }}</th>
                                                <th>{{ trans('created_by') }}</th>
                                                <th>{{ trans('created_at') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $stock)
                                            <tr>
                                                <td>{{ $stock->id }}</td>
                                                <td>{{ $stock->product?$stock->product->product->name:'-' }}</td>
                                                <td>{{ $stock->in_amount }}</td>
                                                <td>{{ $stock->out_amount }}</td>
                                                <td>{{ $stock->balance }}</td>
                                                <td>{{ $stock->product?$stock->product->branch->name:'-' }}</td>
                                                <td>{{ $stock->product?$stock->product->branch->vendor->name:'-' }}</td>
                                                <td>{{ $stock->user ? $stock->user->first_name." ".$stock->user->last_name : '-' }}</td>
                                                <td>{{ $stock->created_at}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @foreach ($list as $stock)
            <!-- Message Modal -->
                <div class="modal fade" id="delete_model_{{ $stock->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.stocks.destroy', ['branch' => $stock]) }}" method="Post" >
                                @method('DELETE')
                                @csrf
                                <div class="modal-body">

                                {{trans('delete_confirmation_message')}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">{{trans('close')}}</button>
                                    <button type="submit" class="btn btn-primary">{{trans('delete')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- Message Modal closed -->
        @endforeach
    </div>
@stop
