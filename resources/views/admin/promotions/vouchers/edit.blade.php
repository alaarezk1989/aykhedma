@extends('admin.layout')
@section('content')
<?php
use \App\Constants\PromotionTypes;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('vouchers') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}" class="text-light-color">{{ trans('vouchers') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('update_voucher') }} #{{ $item->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('update_voucher') }}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.vouchers.update', ['voucher' => $item]) }}" method="post">
                                    @method("PUT")
                                    @csrf
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
                                                     <label for="title">{{ trans('title') }} *</label>
                                                     <input type="text" class="form-control" name="{{ $lang }}[title]" value="{{ $item->translate($lang)->title }}" id="{{ $lang }}[title]">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-3">
                                            <label for="name">{{ trans('value') }} *</label>
                                            <input type="text" class="form-control" value="{{ old("value", $item->value) }}" name="value"  id="value">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="name">{{ trans('expire_date') }} *</label>
                                        <input type="text" class="form-control dateTo" value="{{ old("expire_date", $item->expire_date) }}" name="expire_date"  id="expire_date">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="vendor_id">{{trans('vendor')}}</label>
                                            <select name="vendor_id"  class="form-control select2 w-100" id="vendor_id">
                                                <option value="">{{ trans('select_vendor') }}</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}" {{ old("vendor_id", $item->vendor_id) == $vendor->id ? "selected":null }}>{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="branch_id">{{trans('branch')}}</label>
                                            <select name="branch_id"  class="form-control select2 w-100" id="branch_id" >
                                                <option value="">{{ trans('select_branch') }}</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old("branch_id",$item->branch_id) == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{--<div class="form-group col-md-4">--}}
                                        {{--<div class="form-group overflow-hidden">--}}
                                            {{--<label for="activity_id">{{trans('activity')}}</label>--}}
                                            {{--<select name="activity_id"  class="form-control select2 w-100">--}}
                                                {{--<option value="">{{ trans('select_activity') }}</option>--}}
                                                {{--@foreach($activities as $activity)--}}
                                                    {{--<option value="{{ $activity->id }}" {{ old("activity_id", $item->activity_id) == $activity->id ? "selected":null }}>{{ $activity->name }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="segmentation_id">{{trans('segmentation')}}</label>
                                            <select name="segmentation_id"  class="form-control select2 w-100">
                                                <option value="">{{ trans('select_segmentation') }}</option>
                                                @foreach($segmentations as $segmentation)
                                                    <option value="{{ $segmentation->id }}" {{ old("segmentation_id", $item->segmentation_id) == $segmentation->id ? "selected":null }}>{{ $segmentation->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="company_id">{{trans('company')}}</label>
                                            <select name="company_id"  class="form-control select2 w-100">
                                                <option value="">{{ trans('select_company') }}</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}" {{ old("company_id", $item->company_id) == $company->id ? "selected":null }}>{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ $item->active ? 'checked' : '' }} class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{ trans('active') }}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i>{{ trans('save') }}</button>
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
