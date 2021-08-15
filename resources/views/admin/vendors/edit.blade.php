@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('vendors')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.vendors.index') }}" class="text-light-color">{{trans('vendors')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_vendor')}} #{{ $vendor->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_vendor')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.vendors.update', ['vendor' => $vendor]) }}" method="post" enctype="multipart/form-data">
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
                                                    <label for="name">{{trans('name')}} *</label>
                                                    <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ $vendor->translate($lang)->name }}" id="{{ $lang }}[name]">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="activity_id">{{trans('activity')}} *</label>
                                            <select name="activity_id"  class="form-control select2 w-100" id="activity_id" >
                                                <option value="">{{ trans('select_activity') }}</option>
                                                @foreach($activities as $activity)
                                                    <option value="{{ $activity->id }}" {{ old("activity_id",$vendor->activity_id) == $activity->id ? "selected":null }}>{{ $activity->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group overflow-hidden">
                                            <label for="type">{{trans('type')}}</label>
                                            <select name="type"  class="form-control select2 w-100" id="type" >
                                                <option value="">{{ trans('select_type') }} *</option>
                                                @foreach($types as $key => $value)
                                                    <option value="{{ $key }}" {{ old("type",$vendor->type) == $key ? "selected":null }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="mobile">{{trans('mobile')}}</label>
                                        <input type="text" class="form-control" name="mobile" value="{{old('mobile', $vendor->mobile)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="phone">{{trans('phone')}} *</label>
                                        <input type="text" class="form-control" name="phone" value="{{old('phone', $vendor->phone)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">{{trans('email')}}</label>
                                        <input type="text" class="form-control" name="email" value="{{old('email', $vendor->email)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="administrator">{{trans('administrator')}}</label>
                                        <input type="text" class="form-control" name="administrator" value="{{old('administrator', $vendor->administrator)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="administrator_phone">{{trans('administrator_phone')}}</label>
                                        <input type="text" class="form-control" name="administrator_phone" value="{{old('administrator_phone', $vendor->administrator_phone)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="administrator_email">{{trans('administrator_email')}}</label>
                                        <input type="text" class="form-control" name="administrator_email" value="{{old('administrator_email', $vendor->administrator_email)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="administrator_job">{{trans('administrator_job')}}</label>
                                        <input type="text" class="form-control" name="administrator_job" value="{{old('administrator_job', $vendor->administrator_job)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="commercial_registration_no">{{trans('commercial_registration_no')}}</label>
                                        <input type="number" min="0" class="form-control" name="commercial_registration_no" value="{{old('commercial_registration_no', $vendor->commercial_registration_no)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="tax_card">{{trans('tax_card')}}</label>
                                        <input type="text" class="form-control" name="tax_card" value="{{old('tax_card', $vendor->tax_card)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="other">{{trans('other')}}</label>
                                        <textarea class="form-control" rows="4" cols="50" name="other" id="other" >{{ old("other", $vendor->other) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <br><br>
                                        <p style ="margin-top:-30px ">{{ trans('notice_image_ratio_should_be_1to1') }} * </p>
                                        <label class="custom-switch">
                                            <input type="hidden" id="default" name="logo" value="{{ $vendor->logo }}">
                                            <input type="file" onchange="readURL(this,'upload_img');" name="logo" class="image" style="visibility: hidden;">
                                            <img id="upload_img" src="{{ asset($vendor->logo) }}">
                                        </label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ $vendor->active ? 'checked' : '' }} class="custom-switch-input">
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

    /****** to preview uploaded image ******/
    function readURL(input, img_id) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var image_id=$('#' + img_id);
            reader.onload = function (e) {
                image_id.attr('src', e.target.result);
            };
            image_id.css("width", "260px");
            image_id.css("height", "261px");
            reader.readAsDataURL(input.files[0]);
            $("#default").remove();
        }
    }

</script>
@stop
