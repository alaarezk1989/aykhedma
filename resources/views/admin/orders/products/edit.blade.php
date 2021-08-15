@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('order_products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.order.products.index', ['order' => $orderProduct->order_id]) }}" class="text-light-color">{{trans('order_products')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_order_products')}} #{{ $orderProduct->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_order_products')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.order.products.update', ['order'=>$orderProduct->order_id,'orderProduct' => $orderProduct]) }}" method="post">
                                    @method("PUT")
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <input type="hidden" name="order_type" value="{{$order->type}}">
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('branch')}} *</label>
                                            <select name="branch_id"  class="form-control select2 w-100" id="branch_id">
                                                <option value="">{{ trans('select_branch') }}</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id', $order->branch_id) == $branch->id ? 'selected':null }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('products')}} *</label>
                                            <select name="branch_product_id"  class="form-control select2 w-100" id="branch_product_id" >
                                            <option value="">{{ trans('select_product') }}</option>
                                                @foreach($branchProducts as $branchProduct)
                                                    <option value="{{ $branchProduct->id }}" {{ $branchProduct->id == old( 'branch_product_id', $orderProduct->branch_product_id) ? "selected":null }}>{{ $branchProduct->product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" value="{{ old('price',$orderProduct->price) }}" name="price" id="price" >

                                    <div class="form-group col-md-4">
                                        <label for="quantity">{{ trans('quantity') }} *</label>
                                        <input type="number" min="1" class="form-control" value="{{ old('quantity',$orderProduct->quantity) }}" name="quantity" id="quantity" >
                                        <input type="hidden" value="{{ $orderProduct->quantity }}" name="old_quantity" id="old_quantity" >
                                        <input type="hidden" value="{{ $orderProduct->branch_product_id }}" name="old_product" id="old_product">
                                    </div>
                                    @if($order->type == \App\Constants\OrderTypes::SHIPMENT)
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label>{{trans('time_slot')}} *</label>
                                                <select name="shipment_id"  class="form-control select2 w-100" id="shipment_id" >
                                                    <option value="">{{ trans('select_time_slot') }}</option>
                                                    @foreach($timeSlots as $timeSlot)
                                                        <option value="{{ $timeSlot->id }}" {{ old("shipment_id", $order->shipment_id) == $timeSlot->id ? "selected":null }}>{{ $timeSlot->title." ".trans('from')." ".$timeSlot->from_time." ".trans('to')." ".$timeSlot->to_time }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
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

