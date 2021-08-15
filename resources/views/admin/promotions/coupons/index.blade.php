@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('coupons') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('coupons') }}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.coupons.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('title') }}" class="form-control"
                                               value="{{ request("title") }}" name="title">
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
                                <a href="{{route('admin.coupons.export', array_merge(request()->all(['title'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                @can("create", \App\Models\Coupon::class)
                                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-icon">
                                    <i class="fa fa-plus fa-1x" aria-hidden="true"></i>
                                </a>
                                @endcan
                            </span>
                                <h4>{{ trans('coupons_list') }}</h4>
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
                                @php
                                    // register all permissions of `action` drop down elements hear
                                $permissions = [
                                    "admin.coupons.update",
                                    "admin.coupons.delete",
                                ];
                                @endphp
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>

                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{ trans('title') }}</th>
                                            <th>{{ trans('code') }}</th>
                                            <th>{{ trans('type') }}</th>
                                            <th>{{ trans('value') }}</th>
{{--                                            <th>{{ trans('activity') }}</th>--}}
                                            <th>{{ trans('owner') }}</th>
                                            <th style="width: 1px">{{ trans('expire_date') }}</th>
                                            <th style="width: 1px">{{ trans('status') }}</th>
                                            @if(auth()->user()->hasAccess("admin.coupons.update") || auth()->user()->hasAccess("admin.coupons.destroy"))
                                                <th style="width: 1px">{{ trans('actions') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($coupons as $coupon)
                                            <tr>
                                                <td>{{ $coupon->id }}</td>
                                                <td>{{ $coupon->title }}</td>
                                                <td>{{ $coupon->code }}</td>
                                                <td>{{ \App\Constants\PromotionTypes::getOne($coupon->type) }}</td>
                                                <td>{{ $coupon->value }}</td>
{{--                                                <td>{{ $coupon->activity? $coupon->activity->name: "-" }}</td>--}}
                                                <td>
                                                    @if ($coupon->branch)
                                                        {{$coupon->branch->name}}
                                                    @elseif ($coupon->vendor)
                                                        {{$coupon->vendor->name}}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $coupon->expire_date }}</td>
                                                <td><span
                                                        class="badge badge-{{ $coupon->active ? 'success' : 'danger' }}">{{ $coupon->active? trans('active') : trans('disabled') }}</span>
                                                </td>
                                                @if(auth()->user()->hasAccess("admin.coupons.update") || auth()->user()->hasAccess("admin.coupons.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $coupon)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.coupons.edit', ['coupon' => $coupon->id]) }}">
                                                                        <i class="fa fa-edit"></i> {{ trans('edit') }}
                                                                    </a>
                                                                @endcan
                                                                @can("delete", $coupon)
                                                                    <button type="button" class="dropdown-item has-icon"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_model_{{ $coupon->id }}">
                                                                        <i class="fa fa-trash"></i> {{ trans('remove') }}
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
                                    {{ $coupons->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @foreach ($coupons as $coupon)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $coupon->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{ trans('delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.coupons.destroy', ['coupon' => $coupon]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{ trans('are_you_sure_you_want_to_delete_this') }}?

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{ trans('close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ trans('delete') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Message Modal closed -->
        @endforeach

    </div>
@stop
