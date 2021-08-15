@extends('admin.layout')

@section('content')
<?php
use \App\Constants\PaymentStatus;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('payments')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('payments')}}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.payments.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="status"  class="form-control select2 w-100" id="status" >
                                            <option value="" >{{ trans('select_status') }}</option>
                                            @foreach($status as $key =>$value)
                                                <option value="{{ $key }}" {{ request("status") == $key ? "selected":null }}>{{ $value }}</option>
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
                                    <a href="{{route('admin.payments.export', array_merge(request()->all(['status','from_date','to_date'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", Payment::class)
                                    <a href="{{ route('admin.payments.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>
                                    {{trans('payments_list')}}
                                    @if($totalAmount)
                                        (<small>{{ trans('total_amount') }}</small> <span class="badge badge-success">{{ $totalAmount }}</span>)
                                    @else
                                        (<small>{{ trans('num_rows') }}</small> <span class="badge badge-success">{{ $count }}</span>)
                                    @endif
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
                                                <th style="width: 1px">#</th>
                                                <th style="width: 1px">{{ trans('invoice_number') }}</th>
                                                <th>{{ trans('order_id') }}</th>
                                                <th>{{ trans('final_amount') }}</th>
                                                <th>{{ trans('status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ $payment->invoice_number }}</td>
                                                <td>{{ $payment->order_id }}</td>
                                                <td>{{ $payment->final_amount }}</td>
                                                <td>
                                                    @foreach(PaymentStatus::getList() as $key => $value)

                                                        @if($payment->status == $key)
                                                            {{$value}}
                                                        @endif

                                                    @endforeach
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
