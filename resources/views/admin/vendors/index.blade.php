@extends('admin.layout')

@section('content')
    <?php use App\Constants\VendorTypes;?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('vendors')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('vendors')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <!--row open-->
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
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.vendors.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option value="name" {{ request("filter_by") == "name" ? "selected":null }}>{{ trans('name') }}</option>
                                            <option value="activity_id" {{ request("filter_by") == "activity_id" ? "selected":null }}>{{ trans('activity_id') }}</option>
                                            <option value="zone_id" {{ request("filter_by") == "zone_id" ? "selected":null }}>{{ trans('zone_id') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("q") }}" name="q" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control dateFrom" value="{{ request("from_date") }}" name="from_date" readonly >
                                    </div>
                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_date") }}" name="to_date" readonly >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="type" class="form-control select2 w-100" id="type">
                                            <option value="">{{ trans('select_type') }}</option>
                                            @foreach($types as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ request("type") == $key? "selected":null }}>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 mb-0">{{ trans("search") }}</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--row closed-->
            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    <a href="{{route('admin.vendors.export', array_merge(request()->all(['filter_by','q','from_date','to_date','type'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", \App\Models\Vendor::class)
                                        <a href="{{ route('admin.vendors.create') }}" class="btn btn-icon">
                                            <i class="fa fa-plus fa-1x" aria-hidden="true"></i>
                                        </a>
                                    @endcan
                                </span>
                                <h4>
                                    {{trans('vendors_list')}}
                                    (<small>{{ trans('num_rows') }}</small> <span class="badge badge-success">{{ $count }}</span>)
                                </h4>
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

                                @php
                                    // register all permissions of `action` drop down elements hear
                                $permissions = [
                                    "admin.vendors.update",
                                    "admin.vendors.delete",
                                ];
                                @endphp

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{trans('Activity')}}</th>
                                            <th>{{trans('name')}}</th>
                                            <th>{{trans('type')}}</th>
                                            <th>{{trans('logo')}}</th>
                                            <th style="width: 1px">{{trans('status')}}</th>
                                            @if(auth()->user()->hasAccess("admin.vendors.update") || auth()->user()->hasAccess("admin.vendors.destroy"))
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $vendor)
                                            <tr>
                                                <td>{{ $vendor->id }}</td>
                                                <th>{{ $vendor->activity ? $vendor->activity->name:'-' }}</th>
                                                <td>{{ $vendor->name }}</td>
                                                <td>{{ VendorTypes::getIndex($vendor->type) }}</td>
                                                <td><img style="width: 100px" src="{{ asset($vendor->logo) }}"></td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $vendor->active ? 'success' : 'danger' }}">
                                                        {{ $vendor->active? trans('active') : trans('disabled') }}
                                                    </span>
                                                </td>
                                                @if(auth()->user()->hasAccess("admin.vendors.update") || auth()->user()->hasAccess("admin.vendors.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $vendor)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.vendors.edit', ['vendor' => $vendor->id]) }}">
                                                                        <i class="fa fa-edit"></i> {{trans('edit')}}
                                                                    </a>
                                                                @endcan
                                                                @can("delete", $vendor)
                                                                    <button type="button" class="dropdown-item has-icon"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_model_{{ $vendor->id }}">
                                                                        <i class="fa fa-trash"></i> {{trans('remove')}}
                                                                    </button>
                                                                @endcan
                                                                <a class="dropdown-item has-icon"
                                                                   href="{{ route('admin.vendor.reviews.index', ['vendor' => $vendor->id]) }}">
                                                                    <i class="fa fa-star"></i> {{trans('reviews')}}
                                                                </a>
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


    @foreach ($list as $vendor)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $vendor->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.vendors.destroy', ['vendor' => $vendor]) }}" method="Post">
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
