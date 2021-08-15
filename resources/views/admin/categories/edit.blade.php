@extends('admin.layout')
@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('categories') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-light-color">{{ trans('categories') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('update_category') }} #{{ $item->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ trans('update_category') }}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.categories.update', ['category' => $item]) }}" method="post" enctype="multipart/form-data">
                                    @method('Put')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id}}" />
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
                                                     <label for="name">{{ trans('name') }} *</label>
                                                     <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ $item->translate($lang)->name }}" id="{{ $lang }}[name]">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="categories">{{trans('categories')}}</label>
                                            <select name="parent_id"  class="form-control select2 w-100" id="categories" >
                                                <option value="">{{ trans('parent_category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (old("parent_id") == $category->id or $item->parent_id == $category->id) ? "selected" : null }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <br><br>
                                        <p style ="margin-top:-30px ">{{ trans('notice_image_ratio_should_be_1to1') }} </p>
                                        <label class="custom-switch">
                                            <input type="hidden" id="default" name="image" value="{{ $item->image }}">
                                            <input type="file" onchange="readURL(this,'upload_img');" name="image" class="image" style="visibility: hidden;">
                                            <img id="upload_img" src="{{ asset($item->image) }}">
                                        </label>
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
