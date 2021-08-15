@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('order_products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.order.products.index', ['order' => $order->id]) }}" class="text-light-color">{{trans('order_products')}}</a></li>
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
                                <form action="{{ route('admin.order.products.store',['order'=>$order->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <input type="hidden" name="order_type" value="{{$order->type}}">
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('branch')}} *</label>
                                            <select name="branch_id"  class="form-control select2 w-100" id="branch_id">
                                                <option value="">{{ trans('select_branch') }}</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected':null }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('products')}} *</label>
                                            <select name="branch_product_id"  class="form-control select2 w-100" id="branch_product_id" >
                                            <option value="">{{ trans('select_product') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="quantity">{{ trans('quantity') }} *</label>
                                        <input type="number" min="1" class="form-control" value="{{ old('quantity') }}" name="quantity" id="quantity" >
                                    </div>
                                    @if($order->type == \App\Constants\OrderTypes::SHIPMENT)
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('time_slot')}} *</label>
                                            <select name="shipment_id"  class="form-control select2 w-100" id="shipment_id" >
                                                <option value="">{{ trans('select_time_slot') }}</option>
                                                @foreach($timeSlots as $timeSlot)
                                                    <option value="{{ $timeSlot->id }}" {{ old("shipment_id") == $timeSlot->id ? "selected":null }}>{{ $timeSlot->title." ".trans('from')." ".$timeSlot->from_time." ".trans('to')." ".$timeSlot->to_time }}</option>
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
@endsection
@section('scripts')
    <script>
        $('#branch_id').on('change', function() {
            var lang = '{{ app()->getLocale() }}';
            var l = 0;
            if (lang == 'en') {
                l = 1;
            }

            $.ajax({
                url: '{{ route("api.search.products") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}', 'branch':this.value},

                success: function(data){
                    let html='<option value ="">{{ trans("select_product") }}</option>';
                    let i;
                    for(i=0;i<data.length;i++){
                        html+=
                            '<option value ="'+data[i].id+'">'+data[i].product.translations[l].name+'</option>';
                    }
                    $('#branch_product_id').html(html);
                },
                error: function(){
                    alert("error");
                }
            });
            ///////////////////////////////////////////////////////
            @if($order->shipment_id)
            $.ajax({
                url: '{{ route("api.order.time.slot") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}', 'user_address': '{{ $order->address?$order->address->location->id:null }}' ,'branch_id':this.value},

                success: function(data){
                    var html2='<option value ="">{{ trans("select_time_slot") }}</option>';
                    var i;
                    for(i=0;i<data.result.length;i++){
                        html2+=
                            '<option value ="'+data.result[i].id+'">'+data.result[i].translations[l].title+' {{ trans("from") }} ' + data.result[i].from_time + ' {{ trans("to") }} ' + data.result[i].to_time +'</option>';
                    }
                    $('#shipment_id').html(html2);
                },
                error: function(){
                    alert("error");
                }
            });
            @endif
            ///////////////////////////////////////////////////////
        });
    </script>
@endsection

