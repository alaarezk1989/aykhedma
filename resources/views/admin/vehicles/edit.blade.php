@extends('admin.layout')

@section('content')
<?php
    use \App\Constants\VehicleStatus;
    use \App\Constants\VehicleTypes;
?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('vehicles')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.vehicles.index') }}" class="text-light-color">{{trans('vehicles')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_vehicle')}} #{{ $vehicle->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_vehicles')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.vehicles.update', ['vehicle' => $vehicle]) }}" method="post" enctype="multipart/form-data">
                                    @method("PUT")
                                    @csrf
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $lang == app()->getLocale() ? 'active': ''}} show" id="home-tab2" data-toggle="tab" href="#lang-{{ $lang }}" role="tab" aria-controls="home" aria-selected="true">{{ trans($language) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <div class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}" id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                                <div class="form-group col-md-4">
                                                    <label for="name">{{trans('name')}} *</label>
                                                    <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ old($lang.'.name', $vehicle->translate($lang)->name) }}" id="{{ $lang }}[name]">
                                                </div>


                                            </div>
                                        @endforeach
                                    </div>

                                     <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="type_id">{{trans('type')}} *</label>
                                            <select name="type_id"  class="form-control select2 w-100" id="type_id" >
                                                <option value="">{{ trans('select_type') }}</option>
                                                @foreach(VehicleTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ old('type_id', $vehicle->type_id) == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="assignee">{{trans('driver')}} *</label>
                                            <select name="driver_id"  class="form-control select2 w-100" id="driver_id" >
                                                <option value="">{{ trans('select_driver') }}</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}" {{ old("driver_id", $vehicle->driver_id) == $driver->id ? "selected" : null }}>{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="shipping_company_id">{{trans('shipping_companies')}}</label>
                                            <select name="shipping_company_id"  class="form-control select2 w-100" id="shipping_company_id" >
                                                <option value="">{{ trans('select_shipping_company') }}</option>
                                                @foreach($shippingCompanies as $shippingCompany)
                                                    <option value="{{ $shippingCompany->id }}" {{ old("shipping_company_id", $vehicle->shipping_company_id) == $shippingCompany->id ? "selected" : null }}>{{ $shippingCompany->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="status_id">{{trans('status')}} *</label>
                                            <select name="status_id"  class="form-control select2 w-100" id="status_id" >
                                                <option value="">{{ trans('select_status') }}</option>
                                                @foreach(VehicleStatus::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ old('status_id',$vehicle->status_id) == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="capacity">{{trans('capacity')}} *</label>
                                      <input type="text" class="form-control" name="capacity" value="{{ old('capacity',$vehicle->capacity) }}"id="capacity" >
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="number">{{trans('number')}} *</label>
                                      <input type="text" class="form-control" name="number" value="{{ old('number', $vehicle->number) }}"id="number" >
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
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
