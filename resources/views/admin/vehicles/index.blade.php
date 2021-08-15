@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\VehicleStatus;
    use \App\Constants\VehicleTypes;
    ?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('vehicles') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('vehicles') }}</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.vehicles.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="type" class="browser-default custom-select" id="type">
                                            <option value="">{{ trans('select_type') }}</option>
                                            @foreach($types as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ request("type") == $key ? "selected":null }}>{{ $value}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-3">
                                        <select name="status" class="browser-default custom-select" id="status">
                                            <option value="">{{ trans('select_status') }}</option>
                                            @foreach($status as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ request("status") == $key ? "selected":null }}>{{ $value}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-3">
                                        <select name="driver" class="browser-default custom-select" id="driver">
                                            <option value="">{{ trans('select_driver') }}</option>

                                            @foreach($drivers as $driver)
                                                @if($driver->driver)
                                                    <option value="{{ $driver->driver->id }}" {{ request("driver") == $driver->driver->id  ? "selected":null }}>{{ $driver->driver->first_name." ".$driver->driver->last_name }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <button type="submit"
                                                class="btn btn-primary mt-1 mb-0 col-12"> {{ trans("search") }} </button>
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                     @can("create", \App\Models\Vehicle::class)
                                        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-icon"><i
                                                class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{ trans('vehicles_list') }}</h4>
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
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{trans('name')}}</th>
                                            <th>{{trans('number')}}</th>
                                            <th>{{trans('type')}}</th>
                                            <th>{{ trans('capacity') }}</th>
                                            <th>{{ trans('status') }}</th>
                                            <th>{{trans('driver')}}</th>
                                            <th style="width: 1px">{{ trans('status') }}</th>
                                            @if(auth()->user()->hasAccess("admin.vehicles.update") || auth()->user()->hasAccess("admin.vehicles.destroy"))
                                                <th style="width: 1px">{{ trans('actions') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $vehicle)
                                            <tr>
                                                <td>{{ $vehicle->id }}</td>
                                                <td>{{ $vehicle->name }}</td>
                                                <td>{{ $vehicle->number }}</td>
                                                @foreach(VehicleTypes::getList() as $key => $value)
                                                    @if($vehicle->type_id == $key)
                                                        <td>{{$value}}</td>
                                                    @endif
                                                @endforeach
                                                <td>{{ $vehicle->capacity }}</td>
                                                @foreach(VehicleStatus::getList() as $key => $value)
                                                    @if($vehicle->status_id == $key)
                                                        <td>{{$value}}</td>
                                                    @endif
                                                @endforeach

                                                <td>
                                                    {{ @$vehicle->driver->first_name.' '.@$vehicle->driver->last_name }}</td>

                                                <td><span
                                                        class="badge badge-{{ $vehicle->active ? 'success' : 'danger' }}">{{ $vehicle->active?  trans('active')  :  trans('disabled')  }}</span>
                                                </td>

                                                @if(auth()->user()->hasAccess("admin.vehicles.update") || auth()->user()->hasAccess("admin.vehicles.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $vehicle)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.vehicles.edit', ['vehicle' => $vehicle->id]) }}">
                                                                        <i class="fa fa-edit"></i> {{trans('edit') }}
                                                                    </a>
                                                                @endcan
                                                                @can("delete", $vehicle)
                                                                    <button type="button" class="dropdown-item has-icon"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_model_{{ $vehicle->id }}">
                                                                        <i class="fa fa-trash"></i> {{trans('remove') }}
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
        </section>
    @foreach ($list as $vehicle)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $vehicle->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.vehicles.destroy', ['vehicle' => $vehicle]) }}" method="Post">
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
            <!-- Message Modal closed -->
        @endforeach
    </div>
@stop
