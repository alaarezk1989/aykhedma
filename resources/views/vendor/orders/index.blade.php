@extends('vendor.layout')

@section('content')
<?php
use \App\Constants\OrderStatus;
?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('orders')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('orders')}}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("vendor.orders.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option value="branch_id" {{ request("filter_by") == "branch_id" ? "selected":null }}>{{ trans('branch_id') }}</option>
                                            <option value="address_id" {{ request("filter_by") == "address_id" ? "selected":null }}>{{ trans('address_id') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("q") }}" name="q" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="status"  class="form-control select2 w-100" id="status" >
                                            <option value="" >{{ trans('select_status') }}</option>
                                            @foreach($status as $key =>$value)
                                                <option value="{{ $key }}" {{ request("status") == $key ? "selected":null }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="payment_type"  class="form-control select2 w-100" id="payment_type" >
                                            <option value="" >{{ trans('select_payment_type') }}</option>
                                            @foreach($paymentTypes as $key =>$value)
                                                <option value="{{ $key }}" {{ request("payment_type") == $key ? "selected":null }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control datepicker" value="{{ request("from_date") }}" name="from_date" >
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control datepicker" value="{{ request("to_date") }}" name="to_date" >
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
                                    <a href="{{ route('vendor.orders.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                </span>
                                <h4>{{trans('orders_list')}}</h4>
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
                                                <th>{{trans('branch')}}</th>
                                                <th>{{trans('client_name')}}</th>
                                                <th>{{trans('total_cost')}}</th>
                                                <th>{{trans('address')}}</th>
                                                <th>{{trans('status')}}</th>
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->branch? $order->branch->name: '-' }}</td>
                                                <td>{{ $order->user->first_name." ".$order->user->last_name }}</td>
                                                <td>{{ $order->final_amount ? $order->final_amount : $order->total_price }}</td>
                                                <td>{{ $order->address->location->name }}</td>
                                                <td>
                                                    @foreach(OrderStatus::getList() as $key => $value)
                                                        @if($order->status == $key)
                                                            {{$value}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item has-icon" href="{{ route('vendor.orders.edit', ['order' => $order->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                            <a class="dropdown-item has-icon" href="{{ route('vendor.order.products.index', ['order' => $order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('products')}}</a>
                                                        </div>
                                                    </div>

                                                </td>
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
    </div>
@stop
@section('content')
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('orders')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('orders')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    <a href="{{ route('admin.orders.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                </span>
                                <h4>{{trans('orders_list')}}</h4>
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
                                                <th style="width: 1px">{{trans('order_id')}}</th>
                                                {{-- <th style="width: 1px">{{trans('branch_name')}}</th> --}}
                                                <th>{{trans('client_name')}}</th>
                                                <th>{{trans('address')}}</th>
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->user->first_name." ".$order->user->last_name }}</td>
                                                <td>{{ $order->address->location }}</td>
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item has-icon" href="{{ route('vendor.orders.edit', ['order' => $order->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                            <a class="dropdown-item has-icon" href="{{ route('vendor.orders.show', ['order' => $order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('products')}}</a>
                                                        </div>
                                                    </div>
                                                </td>
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
    </div>
@stop
