@extends('admin.layout')
<?php use \App\Constants\UserTypes;?>
@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('branch_products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a @if(auth()->user()->type == UserTypes::ADMIN) href="{{ route('admin.home.index') }}" @else href="{{ route('vendor.home.index') }}" @endif class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a @if(auth()->user()->type == UserTypes::ADMIN) href="{{ route('admin.branch.products.index', ['branch' => $branch->id]) }}" @else href="{{ route('vendor.branch.products.index', ['branch' => $branch->id]) }}" @endif class="text-light-color">{{trans('branch_products')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_branch_product')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                @section("open-form-tag")
                                    <form action="{{ route('admin.branch.products.store',['branch'=>$branch->id]) }}" method="post">
                                @show
                                    @csrf

                                    <input type="hidden" name="branch_id" value="{{$branch->id}}">
                                    <div class="row">
                                         <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('categories')}}</label>
                                            <select name="category_id"  class="form-control select2 w-100" id="category_id" >
                                            <option value="">{{ trans('select_category') }} *</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old("category_id") == $category->id ? "selected":null }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                <div class="form-group col-md-4"  id="products" @if(!old('category_id')) style="visibility:hidden;" @endif>
                                        <div class="form-group overflow-hidden" >
                                            <label>{{trans('products')}} *</label>
                                            <select name="product_id"  class=" btn-block form-control select2 w-100" id="product_id" >
                                                <option value="">{{ trans('select_product') }}</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" {{ old("product_id") == $product->id ? "selected":null }}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    </div>



                                    <div class="form-group col-md-4">
                                        <label for="price">{{ trans('price') }} *</label>
                                        <input type="text" class="form-control" value="{{ old('price') }}" name="price" id="price" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="discount">{{ trans('discount') }} %</label>
                                        <input type="number" min="0" class="form-control" value="{{ old('discount') }}" name="discount" id="discount" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="discount_till">{{trans('discount_till')}}</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" name="discount_till" id="discount_till" placeholder="{{ trans('discount_till') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>
                                    {{--<div class="form-group col-md-3">--}}
                                        {{--<label class="custom-switch">--}}
                                            {{--<input type="checkbox" name="wholesale" value="1"class="custom-switch-input">--}}
                                            {{--<span class="custom-switch-indicator"></span>--}}
                                            {{--<span class="custom-switch-description">{{trans('wholesale')}}</span>--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
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
@endsection

@section('scripts')
<script>
    $('#category_id').on('change', function() {
        var category =  this.value;
        $.ajax({
                url: '{{ route("api.products.index") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}','category':category},

                success: function(data){
                    $('#products').css('visibility','visible');
                    var html='<option value ="">{{ trans("select_product") }}</option>';
                    var i;
                    for(i=0;i<data.length;i++){
                        html+=
                        '<option value ="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('#product_id').html(html);
                },
                error: function(){
                    //alert("error");
                }
        });
    });

    var $dates = $('#discount_till').datepicker({
        autoclose: true,
        startDate: new Date(),
        endDate: '+5y',
        format: "yyyy-mm-dd",
    });
</script>
@endsection
