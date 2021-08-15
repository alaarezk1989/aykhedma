@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('settings')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('settings')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                </span>
                                <h4>{{trans('settings_list')}}</h4>
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
                                <div><b>{{trans('note')}} :</b></div>
                                <div>1- POINTS_ACQUIRED = {{ trans("POINTS_ACQUIRED") }} </div>
                                <div>2- POINTS_REDEEM = {{ trans("POINTS_REDEEM") }}</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>

                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{trans('key')}}</th>
                                            <th>{{trans('value')}}</th>
                                            <th style="width: 1px">{{trans('status')}}</th>
                                            @if(auth()->user()->hasAccess("admin.settings.update"))
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $setting)
                                            <tr>
                                                <td>{{ $setting->id }}</td>
                                                <td>{{ $setting->key }}</td>
                                                <td>{{ $setting->value }}</td>
                                                <td><span class="badge badge-{{ $setting->active ? 'success' : 'danger' }}">{{ $setting->active? trans('active') : trans('disabled')}}</span></td>
                                                @if(auth()->user()->hasAccess("admin.settings.update"))
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.settings.edit', ['setting' => $setting->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
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
