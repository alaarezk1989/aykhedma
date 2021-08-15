@extends('admin.layout')

@section('content')
<div class="app-content">
    <section class="section">

        <!--page-header open-->
        <div class="page-header">
            <h4 class="page-title">{{ trans('permissions') }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('permissions') }}</li>
            </ol>
        </div>
        <!--page-header closed-->
        <!--row open-->
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{trans('filter_by')}}</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" type="get" action="{{ route("admin.permissions.index") }}">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <input type="text" placeholder="{{ trans('name') }}" class="form-control" value="{{ request("name") }}" name="name" >
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
<!--                            <span class="table-add float-right">
                                <a href="{{ route('admin.permissions.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                            </span>-->
                            <h4>{{ trans('permissions_list') }}</h4>
                        </div>

                        <div class="card-body">
                            @if(session()->has('success'))
                            <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                    </button>
                                    <div class="alert-title">{{ trans('success') }}</div>
                                    {{ session('success') }}
                                </div>
                            </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0 text-nowrap">
                                    <thead>

                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{ trans('name') }}</th>
                                            <th style="width: 1px">{{ trans('status') }}</th>
                                            @if(auth()->user()->hasAccess("admin.permissions.update"))
                                                <th style="width: 1px">{{ trans('actions') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><span class="badge badge-{{ $item->active ? 'success' : 'danger' }}">{{ $item->active? trans('active') : trans('disabled') }}</span></td>
                                            @if(auth()->user()->hasAccess("admin.permissions.update"))
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa-cog fa"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @can('update', $item)
                                                        <a class="dropdown-item has-icon" href="{{ route('admin.permissions.edit', ['permission' => $item->id]) }}"><i class="fa fa-edit"></i> {{ trans('edit') }}</a>
                                                        @endif
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

</div>
@stop
