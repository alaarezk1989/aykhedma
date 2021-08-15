@extends('admin.layout')
@section('content')
<?php
use \App\Constants\ClassTypes;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('new_location')." ( ".trans('zones'). " ) "  }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.locations.index') }}" class="text-light-color">{{ trans('locations') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('update_location')." ( ".trans('zones'). " ) "  }} #{{ $item->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('update_location')." ( ".trans('zones'). " ) "  }}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.locations.update', ['location' => $item]) }}" method="post">
                                    @method("PUT")
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id}}" />
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $lang == app()->getLocale() ? 'active': ''}} show" id="home-tab2" data-toggle="tab" href="#lang-{{ $lang }}" role="tab" aria-controls="home" aria-selected="true">{{ $language }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <div class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}" id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                                <div class="form-group col-md-4">
                                                     <label for="name">{{ trans('name') }} *</label>
                                                     <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ $item->translate($lang)->name }}" id="{{ $lang }}[name]">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="city_id">{{trans('city')}}</label>
                                                <select name="city_id"  class="form-control select2 w-100" id="city_id">
                                                    <option value="">{{ trans('select_city') }}</option>
                                                    @foreach($locations as $location)
                                                        <option value="{{ $location->id}}" {{ old("city_id", $selectedCity) == $location->id ? "selected":null }}>{{ $location->name }}</option>
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
                                                        <option value="{{ $region->id}}" {{ old("region_id", $selectedRegion) == $region->id ? "selected":null }}>{{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group overflow-hidden">
                                            <label for="class">{{trans('class')}}</label>
                                            <select name="class"  class="form-control select2 w-100">
                                                <option value="">{{ trans('select_class') }}</option>
                                                @foreach(ClassTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ $item->class == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ $item->active ? 'checked' : '' }} class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Active</span>
                                        </label>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="Acronym">{{ trans('latitude') }} *</label>
                                        <input type="text" class="form-control" name="lat" value="{{ $item->lat }}" id="lat" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="Acronym">{{ trans('longitude') }} *</label>
                                        <input type="text" class="form-control" name="long" value="{{ $item->long }}" id="long" readonly>
                                    </div>

                                    <input id="pac-input" style="width:350px;height:25px;margin-top:20px;" class="controls" type="text" placeholder="{{trans('search')}}">
                                    <div class="form-group col-md-12" id="map" style="height:400px; width:100%"></div>

                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i> Save</button>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAndFqevHboVWDN156vJqXk1Y1-D7QR7BE&libraries=places&callback=initAutocomplete" async defer></script>
<script>
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
                if ($('#city_id').val() === "") {
                    $('#div_region').css('visibility','hidden');
                }
            },
            error: function(){
                alert("error");
            }
        });
    });
</script>
@endsection
