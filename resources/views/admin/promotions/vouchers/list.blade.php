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
                    <li class="breadcrumb-item"><a href="{{ route('admin.vouchers.index') }}" class="text-light-color">{{ trans('vouchers') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('vouchers_list') }}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.vouchers.list", ['voucher' => $voucher]) }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('code') }}" class="form-control" value="{{ request("code") }}" name="code" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="is_used"  class="form-control select2 w-100" id="is_used" >
                                            <option value="" >{{ trans('select_usage') }}</option>
                                            <option value="0" {{ request("is_used") == '0'? "selected":null }}>{{ trans('not_used') }}</option>
                                            <option value="1" {{ request("is_used") == '1'? "selected":null }} >{{trans('used')}}</option>
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
                                    <a href="{{route('admin.vouchers.list.export', ['voucher' => $voucher])}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                </span>
                                <h4>{{ trans('vouchers_list') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 1px">#</th>
                                                <th>{{ trans('code') }}</th>
                                                <th>{{ trans('value') }}</th>
                                                <th style="width: 1px">{{ trans('expire_date') }}</th>
                                                <th style="width: 1px">{{ trans('is_used') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->value }}</td>
                                                    <td>{{ $item->expire_date }}</td>
                                                    <td><span class="badge badge-{{ $item->is_used ? 'danger' : 'success' }}">{{ $item->is_used? trans('used') : trans('not_used') }}</span></td>
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
