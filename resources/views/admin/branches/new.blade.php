@extends('admin.layout')
<?php use \App\Constants\UserTypes;?>
@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('branches')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a @if(auth()->user()->type == UserTypes::ADMIN) href="{{ route('admin.home.index') }}" @else href="{{ route('vendor.home.index') }}" @endif class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a @if(auth()->user()->type == UserTypes::ADMIN) href="{{ route('admin.branches.index') }}" @else href="{{ route('vendor.branches.index') }}" @endif class="text-light-color">{{trans('branches')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_branch')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')

                                @section("open-form-tag")
                                    <form action="{{ route('admin.branches.store') }}" method="post" autocomplete="off">
                                @show

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
                                                <input type="text" class="form-control" name="{{ $lang }}[name]" id="{{ $lang }}[name]" value="{{ old($lang.'.name') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="name">{{trans('address')}} *</label>
                                                <input type="text" class="form-control" name="{{ $lang }}[address]" id="{{ $lang }}[address]" value="{{ old($lang.'.address') }}">
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>

                                    @section("vendors")
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="vendor_id">{{trans('vendor')}} *</label>
                                                <select name="vendor_id"  class="form-control select2 w-100" id="vendor_id" >
                                                    <option value="">{{ trans('select_vendor') }} </option>
                                                    @foreach($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}" {{ old("vendor_id") == $vendor->id ? "selected":null }}>{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @show

                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="type">{{trans('type')}} *</label>
                                            <select name="type"  class="form-control select2 w-100" id="type" >
                                                <option value="">{{ trans('select_type') }}</option>
                                                @foreach($types as $key => $value)
                                                    <option value="{{ $key }}" {{ old("type") == $key ? "selected":null }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                        <div class="form-group col-md-4">
                                        <label for="start_working_hours">{{trans('start_working_hours')}} *</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o inputIcon"></i>
                                            </div>
                                            <input class="form-control timepicker" type="text" name="start_working_hours" value="{{ old('start_working_hours') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="end_working_hours">{{trans('end_working_hours')}} *</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o inputIcon"></i>
                                            </div>
                                            <input class="form-control timepicker" type="text" name="end_working_hours" value="{{ old('end_working_hours') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="min_order_amount">{{trans('min_order_amount')}} *</label>
                                            <input class="form-control" type="number" min="1" name="min_order_amount" value="{{ old('min_order_amount') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="aykhedma_fee">{{trans('aykhedma_fee')}} *</label>
                                            <input class="form-control" type="number" min="1" name="aykhedma_fee" value="{{ old('aykhedma_fee') }}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="stock_enabled" value="0" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('stock_enabled')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>
                                        <div class="form-group col-md-2">
                                            <label for="name">{{trans('latitude')}}</label>
                                            <input type="text" class="form-control" name="lat" value="{{ old('lat') }}" id="lat" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="name">{{trans('longitude')}}</label>
                                            <input type="text" class="form-control" name="lng" value="{{ old('lng') }}" id="long" readonly>
                                        </div>

                                        <input id="pac-input" style="width:350px;height:25px;margin-top:20px;" class="controls" type="text" placeholder="{{trans('search')}}">
                                        <div class="form-group col-md-12" id="map" style="height:400px; width:100%"></div>

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
        $(document).ready(function(){
            $('input.timepicker').timepicker({});
            $('.timepicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 60,
                minTime: '10',
                maxTime: '6:00pm',
                defaultTime: '11',
                startTime: '10:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAndFqevHboVWDN156vJqXk1Y1-D7QR7BE&libraries=places&callback=initAutocomplete" async defer></script>

@endsection
