@extends('admin.layout')
@section('content')
    <?php
    use \App\Constants\ActualShipmentStatus;
    ?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('actual_shipments') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.actual-shipments.index') }}" class="text-light-color">{{ trans('actual_shipments') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_actual_shipment')}}#{{ $actualShipment->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_actual_shipment')}}</h4>
                            </div>
                            <div class="card-body">
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
                                @include('admin.errors')
                                <form action="{{ route('admin.actual-shipments.update', ['actual-shipment' => $actualShipment]) }}" method="post">
                                    @method('Put')
                                    @csrf
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="vehicle_id">{{trans('vehicles')}}</label>
                                            <select name="vehicle_id"  class="form-control select2 w-100" id="vehicle_id" >
                                                <option value="">{{ trans('select_vehicle') }} *</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ old("vehicle_id", $actualShipment->vehicle_id) == $vehicle->id ? "selected":null }}>{{ $vehicle->name. " - ".$vehicle->capacity." KG"  }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="driver_id">{{trans('delivery_person')}}</label>
                                            <select name="driver_id"  class="form-control select2 w-100" id="driver_id" >
                                                <option value="">{{ trans('select_driver') }} *</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}" {{ old("driver_id", $actualShipment->driver_id) == $driver->id ? "selected":null }}>{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
{{--                                    <div class="form-group col-md-4">--}}
{{--                                        <div class="form-group overflow-hidden">--}}
{{--                                            <label>{{trans('status')}}</label>--}}
{{--                                            <select name="status"  class="form-control select2 w-100" id="status" >--}}
{{--                                                <option value="">{{ trans('select_status') }}</option>--}}
{{--                                                @foreach(ActualShipmentStatus::getList() as $key => $value)--}}
{{--                                                    <option value="{{ $key }}" {{ old("status", $actualShipment->status) == $key ? "selected":null }}>{{ $value }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" class="custom-switch-input" {{ old("active",$actualShipment->active) == 1 ? "checked" : null }}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{ trans('active') }}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i>{{ trans('save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('scripts')
    <script>
        var $dates = $('#dateFrom, #dateTo, #cutoff').datepicker({
            autoclose: true,
            startDate: new Date(),
            endDate: '+5y',
            format: "yyyy-mm-dd",
        });
    </script>
@endsection
