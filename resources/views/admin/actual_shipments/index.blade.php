@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\ObjectTypes;
    use \App\Constants\OrderStatus;
    use \App\Constants\PaymentTypes;
    ?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('actual_shipments')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.actual-shipments.index') }}" class="text-light-color">{{trans('actual_shipments')}}</a></li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            @if(session()->has('danger'))
                                <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                    <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        <div class="alert-title">{{trans('danger')}}</div>
                                        {{ session('danger') }}
                                    </div>
                                </div>
                            @endif
                            <h4>{{ trans('filters') }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.actual-shipments.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('id') }}" class="form-control" value="{{ request("id") }}" name="id">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('title') }}" class="form-control" value="{{ request("title") }}" name="title">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="type" class="browser-default custom-select" >
                                            <option value="">{{ trans('type') }}</option>
                                            <option value="1" {{ request("type") == 1 ? "selected":null }}>{{ trans('parent') }}</option>
                                            <option value="2" {{ request("type") == 2 ? "selected":null }}>{{ trans('child') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="active" class="browser-default custom-select" >
                                            <option value="">{{ trans('status') }}</option>
                                            <option value="1" {{ request("active") == 1 ? "selected":null }}>{{ trans('active') }}</option>
                                            <option value="0" {{ request("active") === "0" ? "selected":null }}>{{ trans('disabled') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"></div>
                                <div class="form-group row">
                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control dateFrom" value="{{ request("from_time") }}" name="from_time" readonly >
                                    </div>

                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_time") }}" name="to_time" readonly >
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 mb-0">{{ trans("search") }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    @if(!request()->get('sub'))
                                        <a href="{{route('admin.actual.shipments.export', array_merge(request()->all(['title'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @endif
                                    @can("create", ActualShipment::class)
                                    {{--<a href="{{ route('admin.actual-shipments.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>--}}
                                    @endcan
                                </span>
                                <h4>{{trans('actual_shipments_list')}}</h4>
                            </div>
                            <div class="card-body">
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
                                @if(session()->has('delete'))
                                    <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                        <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>×</span>
                                            </button>
                                            <div class="alert-title">{{trans('success')}}</div>
                                            {{ session('delete') }}
                                        </div>
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{ trans('title') }}</th>
                                            <th>{{ trans('type') }}</th>
                                            <th>{{ trans('parent_id') }}</th>
                                            <th>{{ trans('from') }}</th>
                                            <th>{{ trans('to') }}</th>
                                            <th>{{ trans('one_delivery_address') }}</th>
                                            <th>{{ trans('from_date') }}</th>
                                            <th>{{ trans('to_date') }}</th>
                                            <th>{{ trans('cutoff') }}</th>
                                            <th>{{ trans('vehicle') }}</th>
                                            <th>{{ trans('driver') }}</th>
                                            <th>{{ trans('delivery_person') }}</th>
                                            <th>{{ trans('capacity') }}</th>
                                            <th>{{ trans('load') }}</th>
                                            <th style="width: 1px">{{ trans('status') }}</th>
                                            @if(auth()->user()->hasAccess("admin.actual_shipments.update") || auth()->user()->hasAccess("admin.actual_shipments.destroy"))
                                            <th style="width: 1px">{{ trans('actions') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $data)
                                            <tr id="sh-{{ $data->id }}" onclick="togle(this)">
                                                <td>{{ $data->id }}</td>
                                                <td>@if($data->parent_id == null)<a href="{{ route('admin.actual-shipments.index').'?sub='.$data->id }}">{{ $data->title }}</a>@else {{ $data->title }} @endif</td>
                                                <td>{{ $data->parent_id == null ? trans("parent"):trans("child") }}</td>
                                                <td>{{ $data->parent_id }}</td>
                                                <td>{{ $data->fromAddress?$data->fromAddress->name:'-' }}</td>
                                                <td>{{ $data->toAddress?$data->toAddress->name:'-' }}</td>
                                                <td>{{ $data->one_address }}</td>
                                                <td>{{ $data->from_time }}</td>
                                                <td>{{ $data->to_time }}</td>
                                                <td>{{ $data->cutoff }}</td>
                                                <td>{{ $data->vehicle ? $data->vehicle->name :'-' }}</td>
                                                <td>{{ $data->vehicle ? $data->vehicle->driver?$data->vehicle->driver->name:'-':'-' }}</td>
                                                <td>{{ $data->deliveryPerson?$data->deliveryPerson->name:'-' }}</td>
                                                <td>{{ $data->capacity }}</td>
                                                <td>
                                                    <div class="container">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $data->load }}" aria-valuemin="0" aria-valuemax="{{ $data->capacity }}" style="width:{{ ($data->load/$data->capacity)*100 }}%">
                                                                <span style="color: #0c0c0c">{{ceil(($data->load/$data->capacity)*100) }}%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge badge-{{ $data->active ? 'success' : 'danger' }}">{{ $data->active? 'Active' : 'Disabled' }}</span></td>
                                                @if(auth()->user()->hasAccess("admin.actual_shipments.update") || auth()->user()->hasAccess("admin.actual_shipments.destroy"))
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can("update", $data)
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.actual-shipments.edit', ['actual-shipment' => $data->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}
                                                            @endcan
                                                            </a>
                                                            @can("delete", $data)
                                                            <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $data->id }}">
                                                                <i class="fa fa-trash"></i> {{trans('remove')}}
                                                            </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @if(count($data->orders) > 0)
                                                <tr class="orders sh-{{$data->id}}" style="background-color:steelblue;  color:white">
                                                    <th  class="text-center" style="visibility:hidden;" >{{trans('related_orders')}}</th>
                                                    <th colspan="8" class="text-center" style="width:100%;" >{{trans('related_orders')}}</th>
                                                </tr>
                                                <tr class="orders sh-{{$data->id}}" style="background-color:steelblue;  color:white">
                                                    <th style="visibility:hidden;" ></th>
                                                    <th class="text-center" >#</th>
                                                    <th class="text-center">{{ trans('date') }}</th>
                                                    <th class="text-center">{{ trans('user') }}</th>
                                                    <th class="text-center">{{ trans('final_amount') }}</th>
                                                    <th class="text-center">{{ trans('status') }}</th>
                                                    <th class="text-center">{{ trans('payment_type') }}</th>
                                                    <th class="text-center">{{trans('sla_status')}}</th>
                                                    <th class="text-center">{{ trans('actions') }}</th>
                                                </tr>
                                        <tbody>
                                        @foreach($data->orders as $order)
                                            <tr class="orders sh-{{$data->id}}" style="background-color:slategray;  color:white">
                                                <td style="visibility:hidden;"></td>
                                                <td class="text-center" >{{$order->id}}</td>
                                                <td class="text-center">{{$order->created_at}}</td>
                                                <td class="text-center">{{$order->user->first_name." ".$order->user->last_name}}</td>
                                                <td class="text-center">{{ $order->final_amount??$order->total_price }}</td>
                                                <td class="text-center">{{OrderStatus::getValue($order->status)}}</td>
                                                <td class="text-center">{{PaymentTypes::getOne($order->payment_type)}}</td>
                                                <td class="text-center"> @if($order->expected_delivery_time < \Carbon\Carbon::now() && ($order->status != \App\Constants\OrderStatus::DELIVERED && $order->status != \App\Constants\OrderStatus::CANCELLED) && $order->expected_delivery_time != null) <span class="alert alert-danger" style="width: 100%"></span>  @else <span class="alert alert-success"></span> @endif</td>
                                                <td>
                                                    <div class="text-center">
                                                        <div class="btn-group dropdown">
                                                            <button type="button" style="background-color:steelblue;" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can('update', $order)
                                                                    <a class="dropdown-item has-icon" href="{{ route('admin.orders.edit', ['order' => $order->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                @endcan
                                                                <a class="dropdown-item has-icon" href="{{ route('admin.order.products.index', ['order' => $order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('products')}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        @endif

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!------------Sub Actual Shipment-------------->
            @if(request()->get('sub'))
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{trans('sub_actual_shipments_list')}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                                            <thead>
                                            <tr>
                                                <th style="width: 1px">#</th>
                                                <th>{{ trans('title') }}</th>
                                                <th>{{ trans('type') }}</th>
                                                <th>{{ trans('parent_id') }}</th>
                                                <th>{{ trans('from') }}</th>
                                                <th>{{ trans('to') }}</th>
                                                <th>{{ trans('one_delivery_address') }}</th>
                                                <th>{{ trans('from_date') }}</th>
                                                <th>{{ trans('to_date') }}</th>
                                                <th>{{ trans('cutoff') }}</th>
                                                <th>{{ trans('vehicle') }}</th>
                                                <th>{{ trans('driver') }}</th>
                                                <th>{{ trans('delivery_person') }}</th>
                                                <th>{{ trans('capacity') }}</th>
                                                <th>{{ trans('load') }}</th>
                                                <th style="width: 1px">{{ trans('status') }}</th>
                                                <th style="width: 1px">{{ trans('actions') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($subList as $subData)
                                                <tr id="sh-{{ $subData->id }}" onclick="togle(this)">
                                                    <td>{{ $subData->id }}</td>
                                                    <td>{{ $subData->title }}</td>
                                                    <td>{{ $subData->parent_id == null ? trans("parent"):trans("child") }}</td>
                                                    <td>{{ $subData->parent_id }}</td>
                                                    <td>{{ $subData->fromAddress?$subData->fromAddress->name:'-' }}</td>
                                                    <td>{{ $subData->toAddress?$subData->toAddress->name:'-' }}</td>
                                                    <td>{{ $subData->one_address }}</td>
                                                    <td>{{ $subData->from_time }}</td>
                                                    <td>{{ $subData->to_time }}</td>
                                                    <td>{{ $subData->cutoff }}</td>
                                                    <td>{{ $subData->vehicle ? $data->vehicle->name :'-' }}</td>
                                                    <td>{{ $data->vehicle ? $data->vehicle->driver ? $data->vehicle->driver->name:'-':'-' }}</td>
                                                    <td>{{ $subData->deliveryPerson? $subData->deliveryPerson->name:'-' }}</td>
                                                    <td>{{ $subData->capacity }}</td>
                                                    <td>
                                                        <div class="container">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $subData->load }}" aria-valuemin="0" aria-valuemax="{{ $subData->capacity }}" style="width:{{ ($subData->load/$subData->capacity)*100 }}%">
                                                                    <span style="color: #0c0c0c">{{ceil(($subData->load/$subData->capacity)*100) }}%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge badge-{{ $subData->active ? 'success' : 'danger' }}">{{ $subData->active? 'Active' : 'Disabled' }}</span></td>
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item has-icon" href="{{ route('admin.actual-shipments.edit', ['actual-shipment' => $subData->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}
                                                                </a>
                                                                <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $subData->id }}">
                                                                    <i class="fa fa-trash"></i> {{trans('remove')}}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(count($subData->orders) > 0)
                                                    <tr class="orders sh-{{$subData->id}}" style="background-color:steelblue;  color:white">
                                                        <th  class="text-center" style="visibility:hidden;" >{{trans('related_orders')}}</th>
                                                        <th colspan="8" class="text-center" style="width:100%;" >{{trans('related_orders')}}</th>
                                                    </tr>
                                                    <tr class="orders sh-{{$subData->id}}" style="background-color:steelblue;  color:white">
                                                        <th style="visibility:hidden;" ></th>
                                                        <th class="text-center" >#</th>
                                                        <th class="text-center">{{ trans('date') }}</th>
                                                        <th class="text-center">{{ trans('user') }}</th>
                                                        <th class="text-center">{{ trans('final_amount') }}</th>
                                                        <th class="text-center">{{ trans('status') }}</th>
                                                        <th class="text-center">{{ trans('payment_type') }}</th>
                                                        <th class="text-center">{{trans('sla_status')}}</th>
                                                        <th class="text-center">{{ trans('actions') }}</th>
                                                    </tr>
                                            <tbody>
                                            @foreach($subData->orders as $order)
                                                <tr class="orders sh-{{$subData->id}}" style="background-color:slategray;  color:white">
                                                    <td style="visibility:hidden;"></td>
                                                    <td class="text-center" >{{$order->id}}</td>
                                                    <td class="text-center">{{$order->created_at}}</td>
                                                    <td class="text-center">{{$order->user->first_name." ".$order->user->last_name}}</td>
                                                    <td class="text-center">{{ $order->final_amount??$order->total_price }}</td>
                                                    <td class="text-center">{{OrderStatus::getValue($order->status)}}</td>
                                                    <td class="text-center">{{PaymentTypes::getOne($order->payment_type)}}</td>
                                                    <td class="text-center"> @if($order->expected_delivery_time < \Carbon\Carbon::now() && ($order->status != \App\Constants\OrderStatus::DELIVERED && $order->status != \App\Constants\OrderStatus::CANCELLED) && $order->expected_delivery_time != null) <span class="alert alert-danger" style="width: 100%"></span>  @else <span class="alert alert-success"></span> @endif</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <div class="btn-group dropdown">
                                                                <button type="button" style="background-color:steelblue;" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa-cog fa"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @can('update', $order)
                                                                        <a class="dropdown-item has-icon" href="{{ route('admin.orders.edit', ['order' => $order->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                    @endcan
                                                                    <a class="dropdown-item has-icon" href="{{ route('admin.order.products.index', ['order' => $order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('products')}}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </section>
    @foreach ($list as $data)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.actual-shipments.destroy', ['actual-shipment' => $data]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{trans('close')}}</button>
                                <button type="submit" class="btn btn-primary">{{trans('delete')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($subList as $subData)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $subData->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.actual-shipments.destroy', ['actual-shipment' => $subData]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{trans('close')}}</button>
                                <button type="submit" class="btn btn-primary">{{trans('delete')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script type="text/javascript">
        function togle(e){
            var orders = document.getElementsByClassName(e.id);
            for(var i=0; i < orders.length; i++)
            {
                var order = orders[i];
                if(order.style.display == 'none'){
                    order.style.display = null ;
                }
                else {
                    order.style.display = 'none' ;
                }
            }
        }
    </script>
@stop
