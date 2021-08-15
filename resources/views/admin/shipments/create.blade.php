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
                <h4 class="page-title">{{trans('shipments')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}"
                                                   class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.shipments.index') }}"
                                                   class="text-light-color">{{trans('shipments')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_shipment')}}</h4>
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
                                <form action="{{ route('admin.shipments.store') }}" method="post">
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
{{--                                    <input type="hidden" name="parent_id" value="{{$parent_id}}">--}}
                                    <div class="tab-content">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <div class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}" id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                                <div class="row">
                                                    <div class="form-group col-md-8">
                                                        <label for="title">{{trans('title')}} *</label>
                                                        <input type="text" class="form-control" value="{{ old( $lang.'.title' ) }}" name="{{ $lang }}[title]" id="title">
                                                    </div>
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
                                                        <option value="{{ $branch->id }}" {{ old("branch_id") == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="parent_id">{{trans('parent_shipment')}}</label>
                                                <select name="parent_id" class="form-control select2 w-100" id="parent_id">
                                                    <option value="">{{ trans('parent_shipment') }}</option>
                                                    @foreach($shipments as $shipment)
                                                        <option value="{{ $shipment->id }}" {{ old("parent_id") == $shipment->id ? "selected":null }}>{{ $shipment->title }}</option>
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
                                    <div class="row" >
                                        <div class="form-group col-md-4">
                                            <label for="from_time">{{trans('from_time')}} *  ex: (04:00 PM)</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="time" class="form-control pull-right " name="from_time" id="dateFrom" value="{{ old('from_time') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="to_time">{{trans('to_time')}} *  ex: (05:00 PM)</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="time" class="form-control pull-right " name="to_time" id="dateTo" value="{{ old('to_time') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4"  id="recurring-div">
                                            <label for="recurring"> {{trans('recurring')}} *</label>
                                            <select name="recurring" class="form-control select2 w-100" id="recurring">
                                                <option value="">{{ trans('select') }}</option>
                                                @foreach(RecurringTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ old("recurring") == $key ? "selected":null }}>{{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4" @if(!old('recurring') || old('recurring') == RecurringTypes::DAILY) style="visibility: hidden" @endif id="day-div">
                                            <label for="day"> {{trans('day')}}</label>
                                            <select name="day" class="form-control select2 w-100" id="day">
                                                <option value="">{{ trans('select') }}</option>
                                                @for($i = 1 ; $i <=$days ; $i++)
                                                    <option value="{{ $i }}" {{ old("day") == $i ? "selected":null }}>{{ (old('recurring') != RecurringTypes::MONTHLY) || (old('recurring') == RecurringTypes::WEEKLY) || (old('recurring') == RecurringTypes::ONE_TIME) ? WeekDays::getOne($i) : $i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="cut_off_date"> {{trans('cut_off_date')}} *</label>
                                            <select name="cut_off_date" class="form-control select2 w-100" id="cut_off_date">
                                                <option value="">{{ trans('select') }}</option>
                                                @for($i = 1 ; $i <=24 ; $i++)
                                                    <option value="{{ $i }}" {{ old("cut_off_date") == $i ? "selected":null }}>{{ $i }} </option>
                                                @endfor
                                            </select>
                                        </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="vehicle_id">{{trans('vehicles')}} *</label>
                                            <select name="vehicle_id"  class="form-control select2 w-100" id="vehicle_id" >
                                                <option value="">{{ trans('select_vehicle') }}</option>
                                                @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ old("vehicle_id") == $vehicle->id ? "selected":null }}>{{ $vehicle->number." - ".$vehicle->capacity. "KG" }}</option>
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
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="form-group overflow-hidden">
                                                <label for="one_delivery_address">{{trans('one_delivery_address')}} </label>
                                                <input type="text" class="form-control" value="{{ old( 'one_address' ) }}" name="one_address" id="one_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label>{{trans('city')}}</label>
                                                <select name="city_id"  class="form-control select2 w-100" id="city_id" >
                                                    <option value="">{{ trans('select_city') }}</option>
                                                    @foreach($cities as $zone)
                                                        <option value="{{ $zone->id }}" {{ old("city_id") == $zone->id ? "selected":null }}>{{ $zone->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" @if(!old('city_id'))style="visibility: hidden"@endif id="div_region">
                                            <div class="form-group overflow-hidden">
                                                <label for="region_id">{{trans('region')}}</label>
                                                <select name="region_id"  class="form-control select2 w-100" id="region_id">
                                                    <option value="">{{ trans('select_region') }}</option>
                                                    @foreach($regions as $region)
                                                        <option value="{{ $region->id}}" {{ old("region_id") == $region->id ? "selected":null }}>{{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" @if(!old('region_id'))style="visibility: hidden"@endif id="div_district">
                                            <div class="form-group overflow-hidden">
                                                <label for="district_id">{{trans('district')}}</label>
                                                <select name="district_id"  class="form-control select2 w-100" id="district_id">
                                                    @foreach($districts as $district)
                                                        <option value="{{ $district->id}}" {{ old("district_id") == $district->id ? "selected":null }}>{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
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
    function getModelData(modelClass, selecteId) {
        var modelClassValue = modelClass.value;
        var html = '<option value ="">{{ trans("select_type") }}</option>';
        $('#' + selecteId).html(html);
        $.ajax({
            url: '{{ route("api.shipment.ModelData") }}',
            type: 'get',
            data: {_token: '{{ csrf_token() }}', 'modelClass': modelClassValue},

            success: function (data) {
                var i;
                for (i = 0; i < data.length; i++) {
                    html +=
                        '<option value ="' + data[i].id + '">' + data[i].name + '</option>';
                }
                $('#' + selecteId).html(html);
            },
            error: function () {
            }
        });//end ajax
    }

    $('#recurring').on('change', function () {
        $('#day-div').css('visibility','hidden');
        $('#day').val(null);
        var html = '<option value ="">{{ trans("select_day") }}</option>';
        var i;
        if (this.value === '{{ RecurringTypes::WEEKLY }}' || this.value === '{{ RecurringTypes::ONE_TIME }}') {
            var days = ['{{trans('saturday')}}','{{trans('sunday')}}','{{trans('monday')}}','{{trans('tuesday')}}','{{trans('wednesday')}}','{{trans('thursday')}}','{{trans('friday')}}'];
            $('#day-div').css('visibility','visible');
            for (i=1;i<=7;i++) {
                html+= '<option value ="'+i+'">'+days[i-1]+'</option>';
            }
        }
        if(this.value === '{{ RecurringTypes::MONTHLY }}' ) {
            $('#day-div').css('visibility','visible');
            for (i=1;i<=31;i++) {
                html+= '<option value ="'+i+'">'+i+'</option>';
            }
        }
        $('#day').html(html);
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    ///////////////////////////////////////////////////////////
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
    //////////////////////////////////////////////////////////

    // $('#parent_id').on('change', function () {
    //     $('#recurring-div').show();
    //     if (this.value != "") {
    //         $('#day-div').hide();
    //         $('#day').val(null);
    //         $('#recurring-div').hide();
    //         $('#recurring').val(null);
    //     }
    // });
</script>
@endsection
