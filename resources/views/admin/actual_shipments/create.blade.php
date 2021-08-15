@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\ActualShipmentStatus;
    use \App\Constants\VehicleTypes;
    ?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('actual_shipments') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}"
                                                   class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.actual-shipments.index') }}"
                                                   class="text-light-color">{{trans('actual_shipments')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_actual_shipment')}}</h4>
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
                                <form action="{{ route('admin.actual-shipments.store') }}" method="post">
                                    @csrf
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $lang == app()->getLocale() ? 'active': ''}} show"
                                                   id="home-tab2" data-toggle="tab" href="#lang-{{ $lang }}" role="tab"
                                                   aria-controls="home" aria-selected="true">{{ trans($language) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="parent_id" value="{{$parent_id}}">
                                    <div class="tab-content">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <div class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}" id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                                <div class="form-group col-md-4">
                                                    <label for="title">{{trans('title')}} *</label>
                                                    <input type="text" class="form-control" value="{{ old( $lang.'.title' ) }}" name="{{ $lang }}[title]" id="title">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="branch_id">{{trans('branch')}}</label>
                                            <select name="branch_id" class="form-control select2 w-100" id="branch_id">
                                                <option value="">{{ trans('select_branch') }}</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old("branch_id") == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="shipment_id">{{trans('shipment')}} *</label>
                                            <select name="shipment_id" class="form-control select2 w-100" id="units">
                                                <option value="">{{ trans('select_shipment') }}</option>
                                                @foreach($shipments as $row)
                                                    <option value="{{ $row->id }}" {{ old("shipment_id") == $row->id ? "selected":null }}>{{ $row->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="parent_id">{{trans('parent_actual_shipment')}}</label>
                                            <select name="parent_id" class="form-control select2 w-100" id="units">
                                                <option value="">{{ trans('parent_actual_shipment') }}</option>
                                                @foreach($actualShipments as $actualShipment)
                                                    <option value="{{ $actualShipment->id }}" {{ old("parent_id") == $actualShipment->id ? "selected":null }}>{{ $actualShipment->title." ".$actualShipment->to_time }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label>{{trans('from')}} *</label>
                                                <select name="from"  class="form-control select2 w-100" id="from" >
                                                    <option value="">{{ trans('select_from_location') }}</option>
                                                    @foreach($locations as $location)
                                                        <option value="{{ $location->id }}" {{ old("from") == $location->id ? "selected":null }}>{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label>{{trans('to')}} *</label>
                                                <select name="to"  class="form-control select2 w-100" id="to" >
                                                    <option value="">{{ trans('select_to_location') }}</option>
                                                    @foreach($locations as $location)
                                                        <option value="{{ $location->id }}" {{ old("to") == $location->id ? "selected":null }}>{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="cutoff">{{trans('cutoff')}} *</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right " name="cutoff" id="cutoff" placeholder="{{ old('cutoff') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="cutoff_time">{{trans('cutoff_time')}} *</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="time" class="form-control pull-right " name="cutoff_time"  value="{{ old('cutoff_time') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <label for="dateFrom">{{trans('from_date')}} *</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right " name="from_time" id="dateFrom" placeholder="{{ old('from_time') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="from_time">{{trans('from_time')}} *</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="time" class="form-control pull-right " name="from_hour" value="{{ old('from_hour') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <label for="dateTo">{{trans('to_date')}} *</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right dateTo" name="to_time" id="dateTo" placeholder="{{ old('to_time') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="from_time">{{trans('to_time')}} *</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input type="time" class="form-control pull-right " name="to_hour"  value="{{ old('to_hour') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="vehicle_id">{{trans('vehicles')}} *</label>
                                            <select name="vehicle_id"  class="form-control select2 w-100" id="vehicle_id" >
                                                <option value="">{{ trans('select_vehicle') }}</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ old("vehicle_id") == $vehicle->id ? "selected":null }}>{{ $vehicle->name." - ".$vehicle->capacity." KG" }}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="driver_id">{{trans('delivery_person')}} *</label>
                                            <select name="driver_id"  class="form-control select2 w-100" id="driver_id" >
                                                <option value="">{{ trans('select_delivery_person') }}</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}" {{ old("driver_id") == $driver->id ? "selected":null }}>{{ $driver->first_name }} {{ $driver->last_name }}</option>
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
{{--                                                    <option value="{{ $key }}" {{ old("status") == $key ? "selected":null }}>{{ $value }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="form-group col-md-12">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked
                                                   class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i> {{trans('save')}}</button>
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
