@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('quantity_analysis_report') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('quantity_analysis_report') }}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.reports.quantity") }}">
                                <div class="form-group row">
                                    <h4>{{ trans('please_select_one_of_filters') }}</h4>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="vehicle_id" class="form-control select2 w-100" id="vehicle_id">
                                            <option value="" >{{ trans('select_vehicle') }}</option>
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}" {{ request("vehicle_id") == $vehicle->id ? "selected":null }}>{{ $vehicle->name." - ".$vehicle->capacity. "KG" }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
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
                                    <a href="{{route('admin.reports.quantity.export', array_merge(request()->all(['vehicle_id','from_date','to_date'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                </span>
                                <h4>{{ trans('quantity_analysis_report') }}</h4>
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
                                @if(request()->filled('from_date') || request()->filled('to_date') || request()->filled('vehicle_id') || strlen($shipments) > 2)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            @if(request()->filled('from_date'))
                                                <th>{{ trans('from_date') }}</th>
                                            @endif
                                            @if(request()->filled('to_date'))
                                            <th>{{ trans('to_date') }}</th>
                                            @endif
                                            @if(strlen($shipments) > 2)
                                                <th>{{ trans('shipments') }}</th>
                                            @endif
                                            @if(request()->filled('vehicle_id'))
                                                <th>{{ trans('vehicle') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                @if(request()->filled('from_date'))
                                                    <td>{{ request()->get('from_date')  }}</td>
                                                @endif
                                                @if(request()->filled('to_date'))
                                                    <td>{{ request()->get('to_date') }}</td>
                                                @endif
                                                @if(strlen($shipments) > 2)
                                                <td>{{ $shipments }}</td>
                                                @endif
                                                @if(request()->filled('vehicle_id'))
                                                    <td>{{ \App\Models\Vehicle::find(request()->get('vehicle_id'))->name." - ".\App\Models\Vehicle::find(request()->get('vehicle_id'))->capacity. "KG" }}</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('item_name') }}</th>
                                                <th>{{ trans('number_boxes') }}</th>
                                                <th>{{ trans('kilos_per_box') }}</th>
                                                <th>{{ trans('kilos') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $row)
                                                <tr>
                                                    <td>{{ $row->product? $row->product->name:'-'  }}</td>
                                                    <td>{{ $row->boxes }}</td>
                                                    <td>{{ $row->product? $row->product->per_kilogram:'-' }}</td>
                                                    <td>{{ $row->kilos }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
