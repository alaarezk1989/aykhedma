@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\ObjectTypes;
    use \App\Constants\OrderStatus;
    use \App\Constants\PaymentTypes;
    use \App\Constants\RecurringTypes;
    use \App\Constants\WeekDays;
    ?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('shipments')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.shipments.index') }}" class="text-light-color">{{trans('shipments')}}</a></li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('filters') }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.shipments.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('id') }}" class="form-control" value="{{ request("id") }}" name="id">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('title') }}" class="form-control"
                                               value="{{ request("title") }}" name="title">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="type" class="browser-default custom-select" >
                                            <option value="">{{ trans('type') }}</option>
                                            <option value="1" {{ request("type") == 1 ? "selected":null }}>{{ trans('parent') }}</option>
                                            <option value="2" {{ request("type") == 2 ? "selected":null }}>{{ trans('child') }}</option>
                                        </select>
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
                                    <a href="{{route('admin.shipments.export', array_merge(request()->all(['title,sub'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @endif
                                    @can("create", \App\Models\shipment::class)
                                        <a href="{{ route('admin.shipments.create')}}"
                                           class="btn btn-icon"><i
                                                class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('shipments_list')}}</h4>
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
                                                <th>{{ trans('from_address') }}</th>
                                                <th>{{ trans('to_address') }}</th>
                                                <th>{{ trans('one_delivery_address') }}</th>
                                                <th>{{ trans('recurring') }}</th>
                                                <th>{{ trans('day') }}</th>
                                                <th>{{ trans('date_from') }}</th>
                                                <th>{{ trans('date_to') }}</th>
                                                <th>{{ trans('vehicle') }}</th>
                                                <th>{{ trans('driver') }}</th>
                                                <th>{{ trans('delivery_person') }}</th>
                                                <th>{{ trans('capacity') }}</th>
                                                <th>{{ trans('load') }}</th>
                                                @if(auth()->user()->hasAccess("admin.shipments.update") || auth()->user()->hasAccess("admin.shipments.destroy"))
                                                    <th style="width: 1px">{{ trans('actions') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $data)
                                                <tr>
                                                    <td>{{ $data->id }}</td>
                                                    <td>@if($data->parent_id == null)<a href="{{ route('admin.shipments.index').'?sub='.$data->id  }}">{{ $data->title }}</a>@else  {{ $data->title }} @endif</td>
                                                    <td>{{ $data->parent_id == null ? trans("parent"):trans("child") }}</td>
                                                    <td>{{ $data->parent_id }}</td>
                                                    <td>{{ $data->from ? $data->fromAddress->name : '-' }}</td>
                                                    <td>{{ $data->to ? $data->toAddress->name : '-' }}</td>
                                                    <td>{{ $data->one_address }}</td>
                                                    <td>{{ RecurringTypes::getOne($data->recurring) }}</td>
                                                    <td>{{ WeekDays::getOne($data->day) }}</td>
                                                    <td>{{ $data->from_time }}</td>
                                                    <td>{{ $data->to_time }}</td>
                                                    <td>{{ $data->vehicle ? $data->vehicle->name :'-' }}</td>
                                                    <td>{{ $data->vehicle ? $data->vehicle->driver?$data->vehicle->driver->name:'-':'-' }}</td>
                                                    <td>{{ $data->deliveryPerson?$data->deliveryPerson->first_name." ".$data->deliveryPerson->last_name:'-' }}</td>
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
                                                    @if(auth()->user()->hasAccess("admin.shipments.update") || auth()->user()->hasAccess("admin.shipments.destroy"))
                                                        <td>
                                                            <div class="btn-group dropdown">
                                                                <button type="button"
                                                                        class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                    <i class="fa-cog fa"></i>
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @can('update', $data)
                                                                        <a class="dropdown-item has-icon" href="{{ route('admin.shipments.edit', ['shipment' => $data->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                    @endcan
                                                                    @can("delete", $data)
                                                                        <button type="button" class="dropdown-item has-icon"
                                                                                data-toggle="modal"
                                                                                data-target="#delete_model_{{ $data->id }}">
                                                                            <i class="fa fa-trash"></i> {{trans('remove')}}
                                                                        </button>
                                                                    @endcan

                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
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
            @if(request()->get('sub'))
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <span class="table-add float-right">
                                        @can("create", \App\Models\shipment::class)
                                            <a href="{{ route('admin.shipments.create').'?sub='.$parent_id }}"
                                               class="btn btn-icon"><i
                                                    class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                        @endcan
                                    </span>
                                    <h4>{{trans('sub_shipments_list')}}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1px">#</th>
                                                    <th>{{ trans('title') }}</th>
                                                    <th>{{ trans('from_address') }}</th>
                                                    <th>{{ trans('to_address') }}</th>
                                                    <th>{{ trans('one_delivery_address') }}</th>
                                                    <th>{{ trans('recurring') }}</th>
                                                    <th>{{ trans('day') }}</th>
                                                    <th>{{ trans('date_from') }}</th>
                                                    <th>{{ trans('date_to') }}</th>
                                                    <th>{{ trans('vehicle') }}</th>
                                                    <th>{{ trans('driver') }}</th>
                                                    <th>{{ trans('capacity') }}</th>
                                                    <th>{{ trans('load') }}</th>
                                                    @if(auth()->user()->hasAccess("admin.shipments.update") || auth()->user()->hasAccess("admin.shipments.destroy"))
                                                        <th style="width: 1px">{{ trans('actions') }}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subList as $data)
                                                    <tr id="sh-{{ $data->id }}" onclick="togle(this)">
                                                        <td>{{ $data->id }}</td>
                                                        <td>{{ $data->title }}</td>
                                                        <td>{{ $data->from ? $data->fromAddress->name : '-' }}</td>
                                                        <td>{{ $data->to ? $data->toAddress->name : '-' }}</td>
                                                        <td>{{ $data->one_address }}</td>
                                                        <td>{{ RecurringTypes::getOne($data->recurring) }}</td>
                                                        <td>{{ WeekDays::getOne($data->day) }}</td>
                                                        <td>{{ $data->from_time }}</td>
                                                        <td>{{ $data->to_time }}</td>
                                                        <td>{{ $data->vehicle ? $data->vehicle->name :'-' }}</td>
                                                        <td>{{ $data->deliveryPerson?$data->deliveryPerson->first_name." ".$data->deliveryPerson->last_name:'-' }}</td>
                                                        <td>{{ $data->capacity }}</td>
                                                        <td>
                                                            <div class="container">
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $data->load }}" aria-valuemin="0" aria-valuemax="{{ $data->capacity }}" style="width:{{ ($data->load/$data->capacity)*100 }}%">
                                                                        <span style="color: #0c0c0c">{{ceil(($data->load/$data->capacity)*100) }}% </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @if(auth()->user()->hasAccess("admin.shipments.update") || auth()->user()->hasAccess("admin.shipments.destroy"))
                                                            <td>
                                                                <div class="btn-group dropdown">
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                        <i class="fa-cog fa"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        @can("delete", $data)
                                                                            <button type="button" class="dropdown-item has-icon"
                                                                                    data-toggle="modal"
                                                                                    data-target="#delete_model_{{ $data->id }}">
                                                                                <i class="fa fa-trash"></i> {{trans('remove')}}
                                                                            </button>
                                                                        @endcan

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
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
        <div class="modal fade" id="delete_model_{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.shipments.destroy', ['shipment' => $data]) }}" method="Post">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            {{trans('delete_confirmation_message_shipment')}}
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

    @if(isset($subList))
        @foreach ($subList as $data)
            <div class="modal fade" id="delete_model_{{ $data->id }}" tabindex="1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.shipments.destroy', ['shipment' => $data]) }}" method="Post">
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
    @endif
</div>
@stop
