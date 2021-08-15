@extends('admin.layout')

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
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('orders')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @if(session()->has('danger'))
                                <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                    <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        <div class="alert-title">{{trans('danger')}}</div>
                                        {{ session('danger') }}
                                    </div>
                                </div>
                            @endif
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.orders.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="vendor_id" class="form-control select2 w-100" id="vendor_id">
                                            <option value="" >{{ trans('select_vendor') }}</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ request("vendor_id") == $vendor->id ? "selected":null }}>{{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="branch_id" class="form-control select2 w-100" id="branch_id">
                                            <option value="" >{{ trans('select_branch') }}</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ request("branch_id") == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="driver_id" class="form-control select2 w-100" id="driver_id">
                                            <option value="" >{{ trans('select_driver') }}</option>
                                            @foreach($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{ request("driver_id") == $driver->id ? "selected":null }}>{{ $driver->name }}</option>
                                            @endforeach
                                        </select>
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
                                        <select name="type" class="form-control select2 w-100" id="type">
                                            <option value="" >{{ trans('select_branch_type') }}</option>
                                            @foreach($types as $key =>$value)
                                                <option value="{{ $key }}" {{ request("type") == $key ? "selected":null }}>{{ $value }}</option>
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
                                        <select name="company"  class="form-control select2 w-100" id="company" >
                                            <option value="" >{{ trans('select_company') }}</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ request("company") == $company->id ? "selected":null }}>{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control dateFrom" value="{{ request("from_date") }}" name="from_date" readonly >
                                    </div>

                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_date") }}" name="to_date" readonly >
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
                                    <a href="{{route('admin.orders.export', array_merge(request()->all(['filter_by','q','status','payment_type','from_date','to_date'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", Order::class)
                                        <a href="{{ route('admin.orders.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>
                                    {{trans('orders_list')}}
                                    (<small>{{ trans('num_rows') }}</small> <span class="badge badge-success">{{ $ordersCount }}</span>)
                                </h4>

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
                                                <th style="width: 1px">{{ trans('order_#') }}</th>
                                                <th>{{trans('shipment_#')}}</th>
                                                <th>{{trans('parent_shipment_#')}}</th>
                                                <th>{{trans('client_name')}}</th>
                                                <th>{{trans('total_cost')}}</th>
                                                <th>{{trans('promo_code')}}</th>
                                                <th>{{trans('promo_type')}}</th>
                                                <th>{{trans('points_used')}}</th>
                                                <th>{{trans('final_amount')}}</th>
                                                <th>{{trans('address')}}</th>
                                                <th>{{trans('status')}}</th>
                                                <th>{{trans('sla_status')}}</th>
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->shipment_id }}</td>
                                                <td>{{ $order->shipment?$order->shipment->parent_id:'-' }}</td>
                                                <td>{{ $order->user ? $order->user->first_name." ".$order->user->last_name : '-' }}</td>
                                                <td>{{ $order->total_price ? $order->total_price  : '-'}}</td>
                                                <td>{{ $order->promo_code ? $order->promo_code  : '-'}}</td>
                                                <td>{{ $order->promo_type }}</td>
                                                <td>{{ $order->points_used ?? '-' }}</td>
                                                <td>{{ $order->final_amount ? $order->final_amount  : '-'}}</td>
                                                <td>{{ $order->address->location->name }}</td>
                                                <td>
                                                @foreach(OrderStatus::getList() as $key => $value)

                                                    @if($order->status == $key)
                                                        {{$value}}
                                                    @endif

                                                @endforeach
                                                </td>
                                                <td> @if($order->expected_delivery_time < \Carbon\Carbon::now() && ($order->status != \App\Constants\OrderStatus::DELIVERED && $order->status != \App\Constants\OrderStatus::CANCELLED) && $order->expected_delivery_time != null) <span class="alert alert-danger" style="width: 100%"></span>  @else <span class="alert alert-success"></span> @endif</td>
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can('update', $order)
                                                                @if($order->status != \App\Constants\OrderStatus::CANCELLED && $order->status != \App\Constants\OrderStatus::DELIVERED)
                                                                <a class="dropdown-item has-icon" href="{{ route('admin.orders.edit', ['order' => $order->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                @endif
                                                            @endcan
                                                            @can("delete", $order)
                                                                <button type="button" class="dropdown-item has-icon"
                                                                        data-toggle="modal"
                                                                        data-target="#delete_model_{{ $order->id }}">
                                                                    <i class="fa fa-trash"></i> {{ trans('remove') }}
                                                                </button>
                                                            @endcan
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.orders.show', ['order' => $order]) }}"><i class="fa fa-eye"></i> {{trans('view')}}</a>
                                                                @if($order->status != \App\Constants\OrderStatus::CANCELLED && $order->status != \App\Constants\OrderStatus::DELIVERED)
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.order.products.index', ['order' => $order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('products')}}</a>
                                                            @endif
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
    @foreach ($list as $order)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $order->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{ trans('delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.orders.destroy', ['order' => $order]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{ trans('are_you_sure_you_want_to_delete_this') }}?

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{ trans('close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ trans('delete') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Message Modal closed -->
        @endforeach
    </div>
@stop
