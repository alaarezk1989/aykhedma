@extends('vendor.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('order_products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendor.order.products.index', ['order' => $order->id]) }}" class="text-light-color">{{trans('order_products')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_order_product')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('vendor.order.products.store',['order'=>$order->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('products')}}</label>
                                            <select name="branch_product_id"  class="form-control select2 w-100" id="branch_product_id" >
                                            <option value="">{{ trans('select_product') }}</option>
                                                @foreach($branchProducts as $branchProduct)
                                                    <option value="{{ $branchProduct->id }}" {{ old("branchProduct_id") == $branchProduct->id ? "selected":null }}>{{ $branchProduct->product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="quantity">{{ trans('quantity') }}</label>
                                        <input type="number" min="1" class="form-control" value="{{ old('quantity') }}" name="quantity" id="quantity" >
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
@endsection

