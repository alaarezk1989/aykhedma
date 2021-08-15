@extends('admin.layout')
<?php
use \App\Constants\PaymentTypes;
use \App\Constants\RevenueTypes;
?>
@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('revenues')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('revenues')}}</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('filters') }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.revenues.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label>{{trans('account_type')}}</label>
                                        <select name="account_type"  class="form-control select2 w-100" id="account_type" >
                                            <option value="">{{ trans('select_account_type') }}</option>
                                            <option value="user">{{ trans('user') }}</option>
                                            <option value="vendor">{{ trans('vendor') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4" id="users" style="display: none">
                                    <div class="form-group overflow-hidden">
                                        <label>{{trans('users')}}</label>
                                        <select name="user_id"  class="form-control select2 w-100" id="user_id">
                                            <option value="">{{ trans('select_user') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" >{{ $user->first_name." ".$user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4" id="vendors" style="display: none">
                                    <div class="form-group overflow-hidden">
                                        <label>{{trans('vendors')}}</label>
                                        <select name="vendor_id"  class="form-control select2 w-100" id="vendor_id">
                                            <option value="">{{ trans('select_vendor') }}</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" >{{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="account_id" id="account_id" value=""/>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control datepicker" value="{{ request("from_date") }}" name="from_date" >
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control datepicker" value="{{ request("to_date") }}" name="to_date" >
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 mb-0">{{ trans("search") }}</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    {{trans('revenues_list')}}
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
                                                <th>{{ trans('account') }}</th>
                                                <th>{{ trans('order') }}</th>
                                                <th>{{ trans('amount') }}</th>
                                                <th>{{ trans('balance') }}</th>
                                                <th>{{ trans('payment_method') }}</th>
                                                <th>{{ trans('type') }}</th>
                                                <th>{{ trans('description') }}</th>
                                                <th>{{ trans('created_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $revenue)
                                            <tr @if($revenue->type == RevenueTypes::REVENUE) style="background-color: lightgreen" @endif>
                                                <td>{{ $revenue->id }}</td>
                                                @if($revenue->accountable_type == 'App\Models\User')
                                                    <td>{{ $revenue->accountable->first_name." ".$revenue->accountable->last_name }}</td>
                                                @else
                                                    <td>{{ $revenue->accountable->name }}</td>
                                                @endif
                                                <td><a href="{{ route('admin.orders.edit',['order' => $revenue->order_id]) }}">{{ $revenue->order_id }}</a></td>
                                                <td>{{ $revenue->amount }}</td>
                                                <td>{{ $revenue->balance }}</td>
                                                <td>{{ PaymentTypes::getOne($revenue->payment_method)}}</td>
                                                <td>{{ \App\Constants\RevenueTypes::getLabel($revenue->type)  }}</td>
                                                <td>{{ $revenue->description }}</td>
                                                <td>{{ $revenue->created_at }}</td>
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
@section('scripts')
    <script>
        $('#account_type').on('change', function(){
            $('#account_id').val('');
            $('#users').hide();
            $('#vendors').show();

            if($(this).val() == 'user'){
                $('#users').show();
                $('#vendors').hide();
            }
        });

        $('#user_id').on('change', function(){
            $('#account_id').val($(this).val());
        });

        $('#vendor_id').on('change', function(){
            $('#account_id').val($(this).val());
        });

    </script>
@endsection
