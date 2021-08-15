@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('orders')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" class="text-light-color">{{trans('orders')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('view')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('view_order')}}</h4>
                            </div>
                            <div class="card-body">
                                <table cellpadding="10" width="100%" cellpadding="10"  class="table-responsive" style="border-color: white">
                                    <tr>
                                        <td width="30%" style="padding: 10px">
                                            <label for="content" class="col-lg-12 control-label">{{ trans('id') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{$order->id}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('user_name') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->user ? $order->user->first_name." ".$order->user->last_name : '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('order_type') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ \App\Constants\OrderTypes::getOne($order->type)}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('shipment_id') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->shipment_id }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('driver') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->driver?$order->driver->first_name." ".$order->driver->last_name : '-'  }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('address') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->address ? $order->address->location? $order->address->location->name: '-' : '-'  }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%">
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('branch') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->branch? $order->branch->name: '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%">
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('promo_code') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->promo_code }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%">
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('promo_type') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->promo_type }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%">
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('points_used') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->points_used }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%">
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('total_price') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->total_price }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%">
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('total_price_after_discount') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->final_amount??$order->total_price }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('payment_type') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ \App\Constants\PaymentTypes::getOne($order->payment_type)}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('created_at') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->created_at}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('expected_delivery_time') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ $order->expected_delivery_time}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr width="15%" >
                                        <td style="padding: 10px">
                                            <label for="content" class="col-sm-12 control-label">{{ trans('status') }}</label>
                                        </td>
                                        <td style="padding: 10px">
                                            <div class="col-sm-12">
                                                {{ \App\Constants\OrderStatus::getValue($order->status)  }}
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('order_products')}}</h4>
                            </div>
                            <div class="card-body">
                                <table cellpadding="10" width="100%" cellpadding="10"  class="table-responsive" style="border-color: white">
                                    @foreach ($products as $product)
                                        <tr width="15%" >
                                            <td style="padding: 10px">
                                                <label for="content" class="col-sm-12 control-label">{{ trans('product_name') }}</label>
                                            </td>
                                            <td style="padding: 10px">
                                                <div class="col-sm-12">
                                                    {{ $product->product?$product->product->name:'-' }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr width="15%" >
                                            <td style="padding: 10px">
                                                <label for="content" class="col-sm-12 control-label">{{ trans('quantity') }}</label>
                                            </td>
                                            <td style="padding: 10px">
                                                <div class="col-sm-12">
                                                    {{ $product->pivot->quantity }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr width="15%" >
                                            <td style="padding: 10px">
                                                <label for="content" class="col-sm-12 control-label">{{ trans('price') }}</label>
                                            </td>
                                            <td style="padding: 10px">
                                                <div class="col-sm-12">
                                                    {{ $product->pivot->price }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
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
    $('#user_id').on('change', function() {
        var user =  this.value;
        $.ajax({
                url: '{{ route("api.addresses.index") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}', 'user':user},

                success: function(data){
                    var html='<option value ="">{{ trans("select_address") }}</option>';
                    var i;
                    for(i=0;i<data.length;i++){
                        html+=
                        '<option value ="'+data[i].id+'">'+data[i].location.name+'</option>';
                    }
                    $('#address_id').html(html);
                },
                error: function(){
                    alert("error");
                }
        });
    });
</script>
@endsection
