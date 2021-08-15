@extends('admin.layout')

@section('content')
<?php
    use \App\Constants\DeliverySla;
    use \App\Constants\UserTypes;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('branch_zones')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a @if(auth()->user()->type == UserTypes::ADMIN) href="{{ route('admin.home.index') }}" @else href="{{ route('vendor.home.index') }}" @endif class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a @if(auth()->user()->type == UserTypes::ADMIN) href="{{ route('admin.branch.zones.index', ['branch' => $branch->id]) }}" @else href="{{ route('vendor.branch.zones.index', ['branch' => $branch->id]) }}" @endif class="text-light-color">{{trans('branch_zones')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_branch_zones')}} #{{ $branchZone->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_branch_zones')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.branch.zones.update' , ['branch'=>$branchZone->branch_id ,'branchZone' => $branchZone]) }}" method="post">
                                    @method("PUT")
                                    @csrf
                                    <input type="hidden" name="branch_id" value="{{$branchZone->branch_id}}">
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
                                    <input type="hidden" name="branch_type" value="{{ $branch->type }}">
                                    @if($branch->type == \App\Constants\BranchTypes::RETAILER)
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label>{{trans('order_delivery_time')}} *</label>
                                                <select name="delivery_sla"  class="form-control select2 w-100" id="delivery_sla" >
                                                    <option value="0">{{ trans('select_time') }}</option>
                                                    @foreach(DeliverySla::getList() as $key => $value)
                                                        <option value="{{ $key }}" {{ $branchZone->delivery_sla == $key ? "selected":null }}> {{ $value }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group col-md-4">
                                        <label for="delivery_fee">{{trans('delivery_fee')}} *</label>
                                        <input type="text" class="form-control" name="delivery_fee" id="delivery_fee" value="{{ old("delivery_fee",$branchZone->delivery_fee) }}">
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
