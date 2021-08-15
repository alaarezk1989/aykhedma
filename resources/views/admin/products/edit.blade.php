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
                    <li class="breadcrumb-item active" aria-current="page">{{trans('edit')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('edit_product')}}</h4>
                            </div>

                            @if(session()->has('success'))
                                <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                    <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        <div class="alert-title">{{trans('success')}}</div>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if(session()->has('error'))
                                <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                    <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        <div class="alert-title">{{trans('error')}}</div>
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif

                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.products.update', ['product' => $product]) }}" enctype="multipart/form-data" method="post">
                                    @method('PUT')
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

                                                <input type="text" class="form-control" value="{{ !old( $lang.'.name') ? $product->translate($lang)->name : old( $lang.'.name') }}" name="{{ $lang }}[name]" id="name" >
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="description">{{trans('description')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[description]" id="description" >{{ !old($lang.".description") ? $product->translate($lang)->description : old($lang.".description") }}</textarea>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="meta_title">{{trans('meta_title')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[meta_title]" id="meta_title" >{{ !old($lang."meta_title") ? $product->translate($lang)->meta_title : old($lang."meta_title") }}</textarea>
                                            </div>


                                            <div class="form-group col-md-4">
                                                <label for="meta_description">{{trans('meta_description')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[meta_description]" id="meta_description" >{{ !old($lang."meta_description") ? $product->translate($lang)->meta_description : old($lang."meta_description") }}</textarea>
                                            </div>


                                            <div class="form-group col-md-4">
                                                <label for="meta_keyword">{{trans('meta_keywords')}} *</label>
                                                <textarea class="form-control" rows="4" cols="50" name="{{ $lang }}[meta_keyword]" id="meta_keyword" >{{ !old($lang."meta_keyword") ? $product->translate($lang)->meta_keyword : old($lang."meta_keyword") }}</textarea>
                                            </div>


                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="code">{{trans('code')}}</label>
                                        <input type="text" class="form-control" value="{{ !old("code") ? $product->code :old("code") }}" name="code" id="code" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="categories">{{trans('categories')}} *</label>
                                            <select name="category_id"  class="form-control select2 w-100" id="categories" >
                                                <option value="">{{ trans('select_category') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (old("category_id") == $category->id or $product->category_id == $category->id) ? "selected" : null }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="units">{{trans('units')}} *</label>
                                            <select name="unit_id"  class="form-control select2 w-100" id="units" >
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ (old("unit_id") == $unit->id or $product->unit_id == $unit->id) ? "selected" : null }}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="unit_value">{{trans('unit_value')}}</label>
                                        <input type="number" class="form-control" value="{{ !old('unit_value') ? $product->unit_value : old('unit_value') }}" name="unit_value" id="unit_value" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="per_kilogram">{{trans('per_kilogram')}} *</label>
                                        <input type="number" min="1" class="form-control" value="{{ !old('per_kilogram') ? $product->per_kilogram : old('per_kilogram') }}" name="per_kilogram" id="per_kilogram" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="manufacturer">{{trans('manufacturer')}}</label>
                                        <input type="text" class="form-control" value="{{ !old("manufacturer") ? $product->manufacturer : old("manufacturer") }}" name="manufacturer" id="manufacturer" >
                                    </div>
                                    <input type="hidden" id="default" name="id" value="{{ $product->id }}">
                                    <input type="hidden" id="default" name="ar_id" value="{{ $product->translate('ar')->id }}">
                                    <input type="hidden" id="default" name="en_id" value="{{ $product->translate('en')->id}}">
                                    <div class="form-group col-md-3">
                                        <br><br>
                                        <p style ="margin-top:-30px ">{{ trans('notice_image_ratio_should_be_1to1') }} </p>
                                        <label class="custom-switch">
                                            <input type="hidden" id="default" name="icon" value="{{ $product->icon }}">
                                            <input type="file" onchange="readURL(this,'upload_img');" name="icon" class="icon" style="visibility: hidden;">
                                            <img id="upload_img" src="{{ asset($product->icon) }}">
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="images">{{trans('images')}} *</label>
                                        <input type="file" name="images[]" multiple>
                                    </div>
                                    <div class="form-group col-md-4">
                                        @foreach($product->images as $productImage)

                                            <div class="img-wrap" id="imageId_{{ $productImage->id }}"  data-toggle="modal" data-target="#delete_model_{{ $productImage->id }}">
                                                <span class="close">&times;</span>
                                                <img src="{{ asset($productImage->image) }}"  data-id="{{ $productImage->id }}">
                                            </div>

                                        @endforeach
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="bundle" value="1" {{ old("bundle",$product->bundle) == 1 ? "checked" : null }}  class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('bundle')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ old("active",$product->active) == 1 ? "checked" : null }}  class="custom-switch-input">
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

    @foreach ($product->images as $image)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $image->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.product.image.destroy', ["product" => $product, 'productImage' => $image]) }}" method="Post" >
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">{{trans('close')}}</button>
                                <button type="submit" class="btn btn-primary">{{trans('delete')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Message Modal closed -->
        @endforeach

    </div>
@stop
<script>
    /****** to preview uploaded icon ******/
    function readURL(input, img_id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var icon_id=$('#' + img_id);
            reader.onload = function (e) {
                icon_id.attr('src', e.target.result);
            };
            icon_id.css("width", "260px");
            icon_id.css("height", "261px");
            reader.readAsDataURL(input.files[0]);
            $("#default").remove();
        }
    }
</script>
