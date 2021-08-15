@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('activities')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}" class="text-light-color">{{trans('activities')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_activity')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.activities.store') }}" enctype="multipart/form-data" method="post">
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
                                                <input type="text" class="form-control" name="{{ $lang }}[name]" id="name" value="{{ old($lang.'.name') }}">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="description">{{trans('description')}} *</label>
                                                <textarea rows="6" class="form-control" name="{{ $lang }}[description]" id="description">{{ old($lang.'.description') }}</textarea>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group col-md-3">
                                        <br>
                                        <p style ="margin-top:-30px ">{{trans('image'). " * ". trans('notice_image_ratio_should_be_1to1') }} </p>
                                        <label class="custom-switch">
                                            <input type="file" onchange="readURL(this,'upload_img');" name="image" class="image"style="visibility: hidden;">
                                            <img id="upload_img" src="{{ asset('assets/img/add_img.jpg')}}">
                                        </label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
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
<script type="text/javascript">

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
    }
}
/****************************************/
</script>
