@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('addresses')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.addresses.index', ['user' => $address->user_id]) }}" class="text-light-color">{{trans('addresses')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_user_addresses')}} #{{ $address->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_user_addresses')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.user.addresses.update', ['user'=>$address->user_id,'address' => $address]) }}" method="post">
                                    @method("PUT")
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$address->user_id}}">
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="city_id">{{trans('city')}} *</label>
                                                <select name="city_id"  class="form-control select2 w-100" id="city_id">
                                                    <option value="">{{ trans('select_city') }}</option>
                                                    @foreach($locations as $location)
                                                        <option value="{{ $location->id}}" {{ $selectedCity == $location->id ? "selected":null }}>{{ $location->name }}</option>
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
                                                        <option value="{{ $region->id}}" {{ $selectedRegion == $region->id ? "selected":null }}>{{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" @if(!old('region_id') && !count($districts))style="visibility: hidden"@endif id="div_district">
                                            <div class="form-group overflow-hidden">
                                                <label for="district_id">{{trans('district')}}</label>
                                                <select name="district_id"  class="form-control select2 w-100" id="district_id">
                                                    @foreach($districts as $district)
                                                        <option value="{{ $district->id}}" {{ $selectedDistrict == $district->id ? "selected":null }}>{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="building">{{ trans('building') }}</label>
                                        <input type="number" min="1" class="form-control" value="{{ old('building', $address->building) }}" name="building" id="building" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="street">{{ trans('street') }}</label>
                                        <input type="text"  class="form-control" value="{{ old('street', $address->street) }}" name="street" id="street" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="floor">{{ trans('floor') }}</label>
                                        <input type="number" min="0" class="form-control" value="{{ old('floor', $address->floor) }}" name="floor" id="floor" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="apartment">{{ trans('apartment') }}</label>
                                        <input type="number" min="0" class="form-control" value="{{ old('apartment', $address->apartment) }}" name="apartment" id="apartment" >
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="name">{{trans('latitude')}}</label>
                                        <input type="text" class="form-control" name="lat" id="lat" value="{{ old("lat", $address->lat) }}" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="name">{{trans('longitude')}}</label>
                                        <input type="text" class="form-control" name="long" id="long" value="{{ old("long",$address->long) }}" readonly>
                                    </div>

                                    <input id="pac-input" style="width:350px;height:25px;margin-top:20px;" class="controls" type="text" placeholder="{{trans('search')}}">
                                    <div class="form-group col-md-12" id="map" style="height: 400px; width: 100%"></div>

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
