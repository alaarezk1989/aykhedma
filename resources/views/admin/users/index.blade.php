@extends('admin.layout')

@section('content')

    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('users')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('users')}}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.users.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option value="name" {{ request("filter_by") == "name" ? "selected":null }}>{{ trans('name') }}</option>
                                            <option value="group_id" {{ request("filter_by") == "group_id" ? "selected":null }}>{{ trans('group_id') }}</option>
                                            <option value="location_id" {{ request("filter_by") == "location_id" ? "selected":null }}>{{ trans('location_id') }}</option>
                                            <option value="category_id" {{ request("filter_by") == "category_id" ? "selected":null }}>{{ trans('order_category_id') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("q") }}" name="q" >
                                    </div>

                                    <div class="col-md-3">
                                        <select name="company_id" class="browser-default custom-select" >
                                            <option value="">{{ trans('select_company') }}</option>
                                            @foreach($companies as $company)
                                                <option
                                                    value="{{ $company->id }}" {{ request("company_id") == $company->id ? "selected":null }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <select name="type"  class="form-control select2 w-100" id="type" >
                                            <option value="" >{{ trans('select_type') }}</option>
                                            @foreach($types as $key =>$value)
                                                <option value="{{ $key }}" {{ request("type") == $key ? "selected":null }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="class"  class="form-control select2 w-100" id="class" >
                                            <option value="" >{{ trans('select_class') }}</option>
                                            @foreach($classes as $key =>$value)
                                                <option value="{{ $key }}" {{ request("class") == $key ? "selected":null }}>{{ $value }}</option>
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
                            <span class="table-add float-right">
                                <a href="{{route('admin.users.export', array_merge(request()->all(['filter_by','q','from_date','to_date','type','class'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                @can("create", User::class)
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-icon">
                                        <i class="fa fa-plus fa-1x" aria-hidden="true"></i>
                                    </a>
                                @endcan

                            </span>
                                <h4>
                                    {{trans('users_list')}}
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
                                            <div class="alert-title">Success</div>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{trans('first_name')}}</th>
                                            <th>{{trans('last_name')}}</th>
                                            <th>{{trans('email')}}</th>
                                            <th>{{trans('phone')}}</th>
                                            <th>{{trans('type')}}</th>
                                            <th>{{trans('image')}}</th>
                                            <th style="width: 1px">{{trans('status')}}</th>
                                            @if(auth()->user()->hasAccess("admin.users.update") || auth()->user()->hasAccess("admin.users.destroy") || auth()->user()->hasAccess("admin.users.groups.index"))
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->first_name }}</td>
                                                <td>{{ $user->last_name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ \App\Constants\UserTypes::getOne($user->type) }}</td>
                                                <td>
                                                    @if($user->image)
                                                    <img style="width: 70px; height: 70px;" src="{{ asset( $user->image) }} ">

                                                    @endif
                                                </td>
                                                <td><span
                                                        class="badge badge-{{ $user->active ? 'success' : 'danger' }}">{{ $user->active? trans('active') : trans('disabled') }}</span>
                                                </td>


                                                @if(auth()->user()->hasAccess("admin.users.update") || auth()->user()->hasAccess("admin.users.destroy") || auth()->user()->hasAccess("admin.users.groups.index") || auth()->user()->hasAccess("admin.users.addresses.index") || auth()->user()->hasAccess("admin.users.devices.index") )
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>


                                                            <div class="dropdown-menu">
                                                                @can("update", $user)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.users.edit', ['user' => $user->id]) }}">
                                                                        <i class="fa fa-edit"></i>{{trans("edit")}}
                                                                    </a>
                                                                @endcan



                                                                @can("index", Address::class)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.user.addresses.index', ['user' => $user->id]) }}"><i
                                                                            class="fa fa-map-marker"></i> {{trans('addresses')}}
                                                                    </a>
                                                                @endcan


                                                                <a class="dropdown-item has-icon"
                                                                   href="{{ route('admin.user.points.index', ['user' => $user->id]) }}"><i
                                                                        class="fa fa-gift"></i> {{trans('points')}}</a>


                                                                @can("index", UserDevice::class)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.user.devices.index', ['user' => $user->id]) }}"><i
                                                                            class="fa fa-tablet"></i> {{trans('devices')}}
                                                                    </a>
                                                                @endcan

                                                                @can("userGroupsIndex", User::class)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.users.groups.index', ['user' => $user->id]) }}">
                                                                        <i class="fa fa-edit"></i> {{trans('groups')}}
                                                                    </a>
                                                                @endcan


                                                                @can("delete", $user)
                                                                    <button type="button" class="dropdown-item has-icon"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_model_{{ $user->id }}">
                                                                        <i class="fa fa-trash"></i> {{trans("remove")}}
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

        </section>
    @foreach ($list as $user)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans("delete")}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">

                                {{trans("delete_confirmation_message")}}

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{trans("close")}}</button>
                                <button type="submit" class="btn btn-primary">{{trans("delete")}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Message Modal closed -->
        @endforeach
    </div>
@stop
