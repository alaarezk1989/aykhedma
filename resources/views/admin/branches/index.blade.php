@extends('admin.layout')
<?php use \App\Constants\BranchTypes;?>
@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('branches')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('branches')}}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.branches.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option value="name" {{ request("filter_by") == "name" ? "selected":null }}>{{ trans('name') }}</option>
                                            <option value="vendor_id" {{ request("filter_by") == "vendor_id" ? "selected":null }}>{{ trans('vendor_id') }}</option>
                                            <option value="zone_id" {{ request("filter_by") == "zone_id" ? "selected":null }}>{{ trans('zone_id') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("q") }}" name="q" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                    <select name="type"  class="form-control select2 w-100" id="type" >
                                        <option value="">{{ trans('select_type') }}</option>
                                        @foreach($types as $key => $value)
                                            <option value="{{ $key}}" {{ request("type") == $key ? "selected":null }}>{{ $value }}</option>
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
                                    <a href="{{route('admin.branches.export', array_merge(request()->all(['filter_by','q','type'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", Branch::class)
                                        <a href="{{ route('admin.branches.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>
                                    {{trans('branches_list')}}
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

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{trans('vendor')}}</th>
                                            <th>{{trans('name')}}</th>
                                            <th>{{trans('address')}}</th>
                                            <th>{{trans('type')}}</th>
                                            <th>{{trans('latitude')}}</th>
                                            <th>{{trans('longitude')}}</th>
                                            <th>{{trans('rate')}}</th>
                                            <th style="width: 1px">{{trans('status')}}</th>
                                            @if(auth()->user()->hasAccess("admin.branches.update") || auth()->user()->hasAccess("admin.branches.destroy"))
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $branch)
                                            <tr>
                                                <td>{{ $branch->id }}</td>
                                                <th>{{ $branch->vendor?$branch->vendor->name:'-' }}</th>
                                                <td>{{ $branch->name }}</td>
                                                <td>{{ $branch->address }}</td>
                                                <td>{{ BranchTypes::getIndex($branch->type) }}</td>
                                                <td>{{ $branch->lat }}</td>
                                                <td>{{ $branch->lng }}</td>
                                                <td>{{ ceil($branch->reviews()->avg('rate')) }}</td>
                                                <td><span class="badge badge-{{ $branch->active ? 'success' : 'danger' }}">{{ $branch->active? trans('active') : trans('disabled') }}</span></td>
                                                @if(auth()->user()->hasAccess("admin.branches.update") || auth()->user()->hasAccess("admin.branches.destroy"))
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can("update", $branch)
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.branches.edit', ['branch' => $branch->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                            @endcan
                                                            @can("delete", $branch)
                                                            <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $branch->id }}">
                                                                <i class="fa fa-trash"></i> {{trans('remove')}}
                                                            </button>
                                                            @endcan
                                                            @can('index', [BranchProduct::class ,$branch])
                                                                <a class="dropdown-item has-icon" href="{{ route('admin.branch.products.index', ['branch' => $branch->id]) }}"><i class="fa fa-eye"></i> {{trans('manage_products')}}</a>
                                                            @endcan
                                                            @can('index', [BranchZone::class ,$branch])
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.branch.zones.index', ['branch' => $branch->id]) }}"><i class="fa fa-map-marker"></i> {{trans('manage_zones')}}</a>
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


    @foreach ($list as $branch)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $branch->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.branches.destroy', ['branch' => $branch]) }}" method="Post" >
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

