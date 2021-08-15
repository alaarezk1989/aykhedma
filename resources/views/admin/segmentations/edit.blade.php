@extends('admin.layout')

@section('content')
<?php
use \App\Constants\ClassTypes;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('segmentations')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.segmentations.index') }}" class="text-light-color">{{trans('segmentations')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_segmentation')}} #{{ $segmentation->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_segmentation')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')

                                @section("open-form-tag")
                                    <form action="{{ route('admin.segmentations.update', ['segmentation' => $segmentation]) }}" method="post">
                                @show

                                    @method("PATCH")
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
                                                    <input type="text" class="form-control" name="{{ $lang }}[title]" value="{{ old($lang.".name", $segmentation->translate($lang)->title)}}" id="{{ $lang }}[title]">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="class">{{trans('user_class')}}</label>
                                            <select name="class"  class="form-control select2 w-100">
                                                <option value="">{{ trans('select_user_class') }}</option>
                                                @foreach(ClassTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ $segmentation->class == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="location_id">{{trans('zone')}}</label>
                                            <select name="location_id"  class="form-control select2 w-100" id="location_id" >
                                                <option value="">{{ trans('select_zone') }}</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}" {{ old("location_id", $segmentation->location_id) == $location->id ? "selected":null }}>{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="location_class">{{trans('zone_class')}}</label>
                                            <select name="location_class"  class="form-control select2 w-100">
                                                <option value="">{{ trans('select_zone_class') }}</option>
                                                @foreach(ClassTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ $segmentation->location_class == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="company_id">{{trans('organization')}}</label>
                                                <select name="company_id"  class="form-control select2 w-100" id="company_id" >
                                                    <option value="">{{ trans('select_company') }}</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}" {{ old("company_id", $segmentation->company_id) == $company->id ? "selected":null }}>{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="orders_category">{{trans('orders_category')}}</label>
                                                <select name="orders_category"  class="form-control select2 w-100" id="orders_category" >
                                                    <option value="">{{ trans('select_orders_category') }}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old("orders_category", $segmentation->orders_category) == $category->id ? "selected":null }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="orders_wish_list_category">{{trans('orders_wish_list_category')}}</label>
                                                <select name="orders_wish_list_category"  class="form-control select2 w-100" id="orders_wish_list_category" >
                                                    <option value="">{{ trans('select_orders_wish_list_category') }}</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old("orders_wish_list_category", $segmentation->orders_wish_list_category) == $category->id ? "selected":null }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="orders_amount">{{trans('previous_orders_amount')}}</label>
                                                <input type="number" min="1" class="form-control" value="{{ old('orders_amount', $segmentation->orders_amount) }}" name="orders_amount" id="orders_amount">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="users_number">{{trans('total_users')}}</label>
                                                <input type="number" min="1" class="form-control" value="{{ old('users_number', $segmentation->users_number) }}" name="users_number" id="users_number">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="weeks_number">{{trans('last_weeks_number')}}</label>
                                                <input type="number" min="1" class="form-control" value="{{ old('weeks_number', $segmentation->weeks_number) }}" name="weeks_number" id="weeks_number">
                                            </div>
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
                    var html = '<option value ="">{{ trans("select_branch") }}</option>';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html +=
                            '<option value ="' + data[i].id + '">' + data[i].name + '</option>';

                    }
                    $('#branch_id').html(html);
                },
                error: function () {
                    // alert("error");
                }
            });//end ajax

        });

    </script>
@stop
