@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('units')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('units')}}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.units.index") }}">
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
                                <span class="table-add float-right">
                                    @can("create", \App\Models\Unit::class)
                                        <a href="{{ route('admin.units.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('units_list')}}</h4>
                            </div>

                            <div class="card-body">
                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                        <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>??</span>
                                            </button>
                                            <div class="alert-title">{{trans('success')}}</div>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $permissions = [
                                        // register all permissions of `action` drop down elements hear
                                        "admin.units.update",
                                        "admin.units.delete",
                                    ];
                                @endphp
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>

                                            <tr>
                                                <th style="width: 1px">#</th>
                                                <th>{{trans('name')}}</th>
                                                <th>{{trans('acronym')}}</th>
                                                <th style="width: 1px">{{trans('status')}}</th>
                                                @if(auth()->user()->hasAccess("admin.units.update") || auth()->user()->hasAccess("admin.units.destroy"))
                                                    <th style="width: 1px">{{trans('actions')}}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $unit)
                                            <tr>
                                                <td>{{ $unit->id }}</td>
                                                <td>{{ $unit->name }}</td>
                                                <td>{{ $unit->acronym }}</td>
                                                <td><span class="badge badge-{{ $unit->active ? 'success' : 'danger' }}">{{ $unit->active? trans('active') : trans('disabled')}}</span></td>

                                                @if(auth()->user()->hasAccess("admin.units.update") || auth()->user()->hasAccess("admin.units.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $unit)
                                                                    <a class="dropdown-item has-icon" href="{{ route('admin.units.edit', ['unit' => $unit->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                @endcan
                                                                @can("delete", $unit)
                                                                    <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $unit->id }}">
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
        </section>

        @foreach ($list as $unit)
            <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $unit->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.units.destroy', ['unit' => $unit]) }}" method="Post" >
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
