@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('coupons')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}" class="text-light-color">{{trans('coupons')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('news')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_coupon')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.coupons.store') }}" method="post">
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
                                                        <label for="title">{{trans('title')}} *</label>
                                                        <input type="text"  name="{{ $lang }}[title]" class="form-control" id="{{ $lang }}[title]" value="{{ old($lang.'.title') }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="vendor">{{trans('vendor')}}</label>
                                        <select name="vendor_id" id="vendor_id"  class="form-control select2 w-100">
                                            <option value="">{{trans('select_vendor')}}</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{$vendor->id}}" {{ old("vendor_id") == $vendor->id ? "selected":null}}>{{$vendor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="branch_id" for="branch">{{trans('branch')}}</label>
                                        <select name="branch_id" class="branch_id branch form-control select2 w-100" value="{{old('branch_id')}}" >
                                            <option value="">{{trans('select_branch')}}</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" {{ old("branch_id") == $branch->id ? "selected":null}}>{{$branch->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

{{--                                    <div class="form-group col-md-4">--}}
{{--                                        <label for="activity">{{trans('activity')}}</label>--}}
{{--                                        <select name="activity_id" id="activity"  value="{{old('activity_id')}}" class="form-control select2 w-100">--}}
{{--                                            <option value="">{{trans('select_activity')}}</option>--}}
{{--                                            @foreach($activities as $activity)--}}
{{--                                                <option value="{{$activity->id}}" {{ old("activity_id") == $activity->id ? "selected":null}}>{{$activity->name}}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="form-group col-md-4">
                                        <label for="code">{{trans('code')}} *</label>
                                        <button type="button" class="btn btn-warning"  onclick="(document.getElementById('code').value ='{{uniqueCode()}}')">generate</button>
                                        <input type="text" class="form-control" value="{{old('code')}}" name="code" id="code">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="type">{{trans('type')}} *</label>
                                        <select name="type" id="type"  value="{{old('type')}}" class="form-control select2 w-100">
                                            <option value="">{{trans('select_type')}}</option>
                                            @foreach($types as $key =>$value)
                                                <option value="{{$key}}" {{ old("type") == $key ? "selected":null}} >{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="value">{{trans('value')}} *</label>
                                        <input type="number" name="value"  value="{{old('value')}}" class="form-control" id="value" min="0">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="minimum_order_price">{{trans('minimum_order_price')}} *</label>
                                        <input type="number"  name="minimum_order_price" value="{{old('minimum_order_price')}}" class="form-control" id="minimum_order_price" min="0">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="to">{{trans('expire_date')}} *</label>
                                        <input type="text" class="form-control dateTo" name="expire_date" value="{{old('expire_date')}}" id="expire_date">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="segmentation_id">{{trans('segmentation')}}</label>
                                        <select name="segmentation_id" id="segmentation_id"  value="{{old('segmentation_id')}}" class="form-control select2 w-100">
                                            <option value="">{{trans('select_segmentation')}}</option>
                                            @foreach($segmentations as $segmentation)
                                                <option value="{{$segmentation->id}}" {{ old("segmentation_id") == $segmentation->id ? "selected":null}}>{{$segmentation->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{ trans('active') }}</span>
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
        $('#vendor_id').on('change', function() {
            var vendor = this.value;
            $.ajax({
                url: '{{ route("api.branches.index") }}',
                type: 'get',
                data: {_token: '{{ csrf_token() }}', 'vendor': vendor},

                success: function (data) {
                    $('.branch_id').css("display","block");
                    var html = '<option value ="">{{ trans("select_branch") }}</option>';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html +=
                            '<option value ="' + data[i].id + '">' + data[i].name + '</option>';

                    }
                    $('.branch').html(html);
                },
                error: function () {
                   //
                }
            });

        });

    </script>

@stop
