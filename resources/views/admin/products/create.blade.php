@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" class="text-light-color">{{trans('products')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_product')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.products.store') }}" enctype="multipart/form-data" method="post">
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

                                                <input type="text" class="form-control" value="{{ old( $lang.'.name' ) }}" name="{{ $lang }}[name]" id="name" >
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="description">{{trans('description')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[description]" id="description" >{{ old($lang.".description") }}</textarea>
                                            </div>


                                            <div class="form-group col-md-4">
                                                <label for="meta_title">{{trans('meta_title')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[meta_title]" id="meta_title" >{{ old($lang.".meta_title") }}</textarea>
                                            </div>


                                            <div class="form-group col-md-4">
                                                <label for="meta_description">{{trans('meta_description')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[meta_description]" id="meta_description" >{{ old($lang.".meta_description") }}</textarea>
                                            </div>


                                            <div class="form-group col-md-4">
                                                <label for="meta_keyword">{{trans('meta_keywords')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[meta_keyword]" id="meta_keyword" >{{ old($lang.".meta_keyword") }}</textarea>
                                            </div>

                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="code">{{trans('code')}} *</label>
                                        <input type="text" class="form-control" value="{{ old("code") }}" name="code" id="code" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="categories">{{trans('categories')}} *</label>
                                            <select name="category_id"  class="form-control select2 w-100" id="units" >
                                                <option value="">{{ trans('select_category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old("category_id") == $category->id ? "selected":null }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="units">{{trans('units')}} *</label>
                                            <select name="unit_id"  class="form-control select2 w-100" id="units" >
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ old("unit_id") == $unit->id ? "selected":null }}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="unit_value">{{trans('unit_value')}}</label>
                                        <input type="number" class="form-control" value="{{ old('unit_value') }}" name="unit_value" id="unit_value" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="per_kilogram">{{trans('per_kilogram')}} *</label>
                                        <input type="number" min="1" class="form-control" value="{{ old('per_kilogram') }}" name="per_kilogram" id="per_kilogram" >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="manufacturer">{{trans('manufacturer')}}</label>
                                        <input type="text" class="form-control" value="{{ old("manufacturer") }}" name="manufacturer" id="manufacturer" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <br><br>
                                        <p style ="margin-top:-30px ">{{ trans('notice_image_ratio_should_be_1to1') }} </p>
                                        <label for="icon">{{ trans('icon') }} * </label>
                                        <input type="file" name="icon" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="meta_keyword">{{trans('images')}} *</label>
                                        <input type="file" name="images[]" multiple>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="bundle" value="1" {{ old("bundle") == 1 ? "checked" : null }} class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('bundle')}}</span>
                                        </label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ old("active") == 1 ? "checked" : null }} class="custom-switch-input">
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
