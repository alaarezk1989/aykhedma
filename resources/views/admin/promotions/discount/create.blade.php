@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\PromotionTypes;
    ?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('discounts')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}"
                                                   class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.discounts.index') }}"
                                                   class="text-light-color">{{trans('discounts')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_discount')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.discounts.store') }}" enctype="multipart/form-data"
                                      method="post">
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
                                    <div class="tab-content">
                                        @foreach(config()->get('app.locales') as $lang => $language)
                                            <div
                                                class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}"
                                                id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                                <div class="form-group col-md-4">
                                                    <label for="title">{{trans('title')}}</label>
                                                    <input type="text" class="form-control" name="{{ $lang }}[title]"
                                                           value="{{ old($lang.".title") }}"
                                                           id="title">
                                                </div>


                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="value">{{trans('value')}}</label>
                                                <input type="number" class="form-control" name="value" id="value"
                                                       value="{{ old('value') }}">
                                            </div>
                                        </div>


                                        <div class="form-group col-md-4" id="vendor">
                                            <div class="form-group overflow-hidden">
                                                <label for="type">{{trans('type')}}</label>
                                                <select name="type" id="type" class="form-control select2 w-100"
                                                        required>
                                                    <option value="">{{ trans('select_type') }}</option>
                                                    @foreach(PromotionTypes::getList() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old("type") == $key ? "selected":null }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <label for="from_date">{{trans('date_from')}}</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right dateFrom"
                                                       name="from_date" id="from" value="{{ old('from_date') }}">
                                            </div>

                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="to_date">{{trans('date_to')}}</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right dateTo"
                                                       name="to_date" id="to" value="{{ old('to_date') }}">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label
                                                    for="minimum_order_price">{{trans('minimum_order_price')}}</label>
                                                <input type="number" class="form-control" name="minimum_order_price"
                                                       id="minimum_order_price"
                                                       value="{{ old('minimum_order_price') }}">
                                            </div>
                                        </div>


                                        <div class="form-group col-md-4" id="vendor">
                                            <div class="form-group overflow-hidden">
                                                <label for="usage_no">{{trans('usage_no')}}</label>
                                                <input type="number" class="form-control" name="usage_no" id="usage_no"
                                                       value="{{ old('usage_no') }}">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="activity_id">{{trans('activity')}}</label>
                                                <select name="activity_id" id="activity_id"
                                                        class="form-control select2 w-100">
                                                    <option value="">{{ trans('select_activity') }}</option>
                                                    @foreach($activities as $activity)
                                                        <option
                                                            value="{{ $activity->id }}" {{ old("activity_id") == $activity->id ? "selected":null }}>{{ $activity->name }}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="vendor_id">{{trans('vendor')}}</label>
                                                <select name="vendor_id" id="vendor_id"
                                                        class="form-control select2 w-100">
                                                    <option value="">{{ trans('select_vendor') }}</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="branch_id">{{trans('select_branch')}}</label>
                                                <select name="branch_id" id="branch_id"
                                                        class="form-control select2 w-100">
                                                    <option value="">{{ trans('select_branch') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked
                                                   class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i
                                                class="fa fa-save"></i> {{trans('save')}}</button>
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

        var activity = $('#activity_id').val();
        if (activity > 0) {
            var deafultHtml = '<option value ="">{{ trans("select_vendor") }}</option>';
            gitActivityVendor(activity,deafultHtml);
        }

        $('#activity_id').on('change', function () {
            var deafultHtml = '<option value ="">{{ trans("select_vendor") }}</option>';
            $('#vendor_id').html(deafultHtml);
            var activity = this.value;
            if (activity > 0) {
                gitActivityVendor(activity, deafultHtml);
            }
        });

        function gitActivityVendor(activity, deafultHtml) {
            $.ajax({
                url: '{{ route("api.vendors.index") }}',
                type: 'get',
                data: {_token: '{{ csrf_token() }}', 'activity': activity},

                success: function (data) {
                    var html = deafultHtml;
                    var i;
                    var old_vendor_id = '{{ old("vendor_id")}}';
                    if(old_vendor_id >0){
                        var deafultHtml2 = '<option value ="">{{ trans("select_branch") }}</option>';
                            gitVendorBranches(old_vendor_id,deafultHtml2);
                    }
                    for (i = 0; i < data.length; i++) {
                        html +=
                            '<option value ="' + data[i].id + '"' + (old_vendor_id == data[i].id ? "selected" : null) + ' >' + data[i].name + '</option>';
                    }
                    $('#vendor_id').html(html);
                },
                error: function () {
                    // alert("error");
                }
            });//end ajax
        }


        $('#vendor_id').on('change', function () {
            var deafultHtml = '<option value ="">{{ trans("select_branch") }}</option>';
            $('#branch_id').html(deafultHtml);
            var vendor = this.value;
            if (vendor > 0) {
                gitVendorBranches(vendor, deafultHtml);
            }
        });

        function gitVendorBranches(vendor, deafultHtml = "") {
            $.ajax({
                url: '{{ route("api.branches.index") }}',
                type: 'get',
                data: {_token: '{{ csrf_token() }}', 'vendor': vendor},

                success: function (data) {
                    var html = deafultHtml;
                    var i;
                    var old_branch_id = '{{ old("branch_id")}}';
                    for (i = 0; i < data.length; i++) {
                        html +=
                            '<option value ="' + data[i].id + '"' + (old_branch_id == data[i].id ? "selected" : null) + ' >' + data[i].name + '</option>';
                    }
                    $('#branch_id').html(html);
                },
                error: function () {
                    // alert("error");
                }
            });//end ajax
        }
    </script>
@endsection
