@extends('admin.layout')

@section('content')
<?php
use \App\Constants\PromotionTypes;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('vouchers') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('vouchers') }}</li>
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
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.vouchers.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option value="title" {{ request("filter_by") == "title" ? "selected":null }}>{{ trans('title') }}</option>
                                            <option value="value" {{ request("filter_by") == "value" ? "selected":null }}>{{ trans('value') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("q") }}" name="q" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control  dateFrom" value="{{ request("from_date") }}" name="from_date" >
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_date") }}" name="to_date" >
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
                                    <a href="{{route('admin.vouchers.export', array_merge(request()->all(['filter_by','q','from_date','to_date'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", Voucher::class)
                                        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>
                                    {{ trans('vouchers_list') }}
                                    (<small>{{ trans('num_rows') }}</small> <span class="badge badge-success">{{ $vouchersCount }}</span>)
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
                                                <th>{{ trans('title') }}</th>
                                                <th>{{ trans('value') }}</th>
                                                <th style="width: 1px">{{ trans('expire_date') }}</th>
                                                <th style="width: 1px">{{ trans('company') }}</th>
                                                <th style="width: 1px">{{ trans('vendor') }}</th>
                                                <th style="width: 1px">{{ trans('branch') }}</th>
{{--                                                <th style="width: 1px">{{ trans('activity') }}</th>--}}
                                                <th style="width: 1px">{{ trans('usage') }}</th>
                                                @if(auth()->user()->hasAccess("admin.vouchers.update") || auth()->user()->hasAccess("admin.vouchers.destroy"))
                                                    <th style="width: 1px">{{ trans('actions') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>{{ $item->value }}</td>
                                                    <td>{{ $item->expire_date }}</td>
                                                    <td>{{ $item->company_id ? $item->company? $item->company->name:'-' : '-' }}</td>
                                                    <td>{{ $item->vendor_id ? $item->vendor->name : '-' }}</td>
                                                    <td>{{ $item->branch_id ? $item->branch?$item->branch->name: '-' : '-' }}</td>
{{--                                                    <td>{{ $item->activity_id ? $item->activity->name : '-' }}</td>--}}
                                                    <td>{{ $item->used($item->id).'/'.$item->number }}</td>
                                                    @if(auth()->user()->hasAccess("admin.vouchers.update") || auth()->user()->hasAccess("admin.vouchers.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $item)
                                                                    <a class="dropdown-item has-icon" href="{{ route('admin.vouchers.edit', ['voucher' => $item]) }}"><i class="fa fa-edit"></i> {{ trans('edit') }}</a>
                                                                @endcan
                                                                @can("delete", $item)
                                                                    <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $item->id }}">
                                                                        <i class="fa fa-trash"></i> {{ trans('remove') }}
                                                                    </button>
                                                                @endcan
                                                                @can("list", $item)
                                                                    <a class="dropdown-item has-icon" href="{{ route('admin.vouchers.list', ['voucher' => $item]) }}"><i class="fa fa-eye"></i> {{ trans('vouchers_list') }}</a>
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
        @foreach ($list as $item)
            <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $item->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.vouchers.destroy', ['voucher' => $item]) }}" method="Post" >
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
