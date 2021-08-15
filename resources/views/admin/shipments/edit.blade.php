@extends('admin.layout')
@section('content')
<?php
    use \App\Constants\RecurringTypes;
    use \App\Constants\WeekDays;

?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">shipments</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home.index') }}"class="text-light-color">{{trans('home')}}</a>
                </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.shipments.index') }}" class="text-light-color">{{trans('shipments') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_shipment')}}
                        #{{ $shipment->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_shipment')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.shipments.update', ['shipment' => $shipment]) }}" method="post">
                                    @method('Put')
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
                                    <input type="hidden" name="parent_id" value="{{$shipment->parent_id}}">
                                    <div class="tab-content">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <div class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}" id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                                <div class="form-group row col-md-8">
                                                    <label for="title">{{trans('title')}} *</label>
                                                    <input type="text" class="form-control" value="{{ !old( $lang.'.title') ? $shipment->translate($lang)->title : old( $lang.'.title') }}" name="{{ $lang }}[title]" id="title">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="branch_id">{{trans('branch')}} *</label>
                                                <select name="branch_id" class="form-control select2 w-100" id="branch_id">
                                                    <option value="">{{ trans('select_branch') }}</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ old("branch_id", $shipment->branch_id) == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="form-group col-md-4">
                                                <div class="form-group overflow-hidden">
                                                    <label>{{trans('from')}} *</label>
                                                    <select name="from"  class="form-control select2 w-100" id="from" >
                                                        <option value="">{{ trans('select_from_location') }}</option>
                                                        @foreach($locations as $location)
                                                            <option value="{{ $location->id }}" {{ old("from", $shipment->from) == $location->id ? "selected":null }}>{{ $location->name }}</option>
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
                                                            <option value="{{ $location->id }}" {{ old("to", $shipment->to) == $location->id ? "selected":null }}>{{ $location->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="vehicle_id">{{trans('vehicles')}} *</label>
                                            <select name="vehicle_id"  class="form-control select2 w-100" id="vehicle_id" >
                                                <option value="">{{ trans('select_vehicle') }}</option>
                                                @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}" {{ (old("vehicle_id") == $vehicle->id or $shipment->vehicle_id == $vehicle->id) ? "selected" : null }}>{{ $vehicle->number." - ".$vehicle->capacity. "KG" }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                   <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="driver_id">{{trans('delivery_person')}} *</label>
                                        <select name="driver_id"  class="form-control select2 w-100" id="driver_id" >
                                                <option value="">{{ trans('select_driver') }}</option>
                                                @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}" {{ (old("driver_id") == $driver->id or $shipment->driver_id == $driver->id) ? "selected" : null }}>{{ $driver->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group overflow-hidden">
                                                <label for="one_delivery_address">{{trans('one_delivery_address')}} </label>
                                                <input type="text" class="form-control" value="{{ old( 'one_address', $shipment->one_address ) }}" name="one_address" id="one_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1"
                                                   class="custom-switch-input" {{ old("active",$shipment->active) == 1 ? "checked" : null }}>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Active</span>
                                        </label>
                                    </div>

                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="city_id">{{trans('city')}} *</label>
                                                <select name="city_id"  class="form-control select2 w-100" id="city_id">
                                                    <option value="">{{ trans('select_city') }}</option>
                                                    @foreach($cities as $location)
                                                        <option value="{{ $location->id}}" {{ @$selectedCity == $location->id ? "selected":null }}>{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" @if(!old('city_id') && !count($regions))style="visibility: hidden"@endif id="div_region">
                                            <div class="form-group overflow-hidden">
                                                <label for="region_id">{{trans('region')}}</label>
                                                <select name="region_id"  class="form-control select2 w-100" id="region_id">
                                                    <option value="">{{ trans('select_region') }}</option>
                                                    @foreach($regions as $region)
                                                        <option value="{{ $region->id}}" {{ @$selectedRegion == $region->id ? "selected":null }}>{{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" @if(!old('region_id') && !count($districts))style="visibility: hidden"@endif id="div_district">
                                            <div class="form-group overflow-hidden">
                                                <label for="district_id">{{trans('district')}}</label>
                                                <select name="district_id"  class="form-control select2 w-100" id="district_id">
                                                    @foreach($districts as $district)
                                                        <option value="{{ $district->id}}" {{ @$selectedDistrict == $district->id ? "selected":null }}>{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i
                                                class="fa fa-save"></i> Save
                                        </button>
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
    $('#recurring').on('change', function () {
        $('#day-div').hide();
        $('#day').val(null);
        var html = '<option value ="">{{ trans("select_day") }}</option>';
        var i;
        if (this.value === '{{ RecurringTypes::WEEKLY }}') {
            var days = ['{{trans('saturday')}}','{{trans('sunday')}}','{{trans('monday')}}','{{trans('tuesday')}}','{{trans('wednesday')}}','{{trans('thursday')}}','{{trans('friday')}}'];
            $('#day-div').show();
            for (i=1;i<=7;i++) {
                html+= '<option value ="'+i+'">'+days[i-1]+'</option>';
            }
        }
        if(this.value === '{{ RecurringTypes::MONTHLY }}' ) {
            $('#day-div').show();
            for (i=1;i<=31;i++) {
                html+= '<option value ="'+i+'">'+i+'</option>';
            }
        }
        $('#day').html(html);
    });

    $('#city_id').on('change', function() {
        var lang = '{{ app()->getLocale() }}';
        var l = 0;
        if (lang == 'en') {
            l = 1;
        }

        $.ajax({
            url: '{{ route("api.locations.index") }}',
            type: 'get',
            data: { _token: '{{ csrf_token() }}', 'city_id' : this.value},
            success: function(data){
                $('#div_region').css('visibility','visible');
                var html='<option value ="">{{ trans("select_region") }}</option>';
                var i;
                for(i = 0; i < data.length; i++) {
                    html+= '<option value ="'+data[i].id+'">'+data[i].translations[l].name+'</option>';
                }
                $('#region_id').html(html);
                $('#district_id').html('');


                if ($('#city_id').val() === "") {
                    $('#div_region').css('visibility','hidden');
                    $('#div_district').css('visibility','hidden');
                }

            },
            error: function(){
                alert("error");
            }
        });
    });
    ////////////////////////////////////////////////////////////////////////////////////////////
    $('#region_id').on('change', function() {
        var lang = '{{ app()->getLocale() }}';
        var l = 0;
        if (lang == 'en') {
            l = 1;
        }
        $.ajax({
            url: '{{ route("api.locations.index") }}',
            type: 'get',
            data: { _token: '{{ csrf_token() }}', 'region_id' : this.value},
            success: function(data){
                $('#div_district').css('visibility','visible');
                var html='';
                var i;
                for(i = 0; i < data.length; i++) {
                    html+= '<option value ="'+data[i].id+'">'+data[i].translations[l].name+'</option>';
                }
                $('#district_id').html(html);
                if ($('#region_id').val() === "") {
                    $('#div_district').css('visibility','hidden');
                }
            },
            error: function(){
                alert("error");
            }
        });
    });
</script>
@endsection
