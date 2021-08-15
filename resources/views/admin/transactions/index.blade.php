@extends('admin.layout')

<?php
    use \App\Constants\TransactionTypes;
    use \App\Constants\OrderTypes;
?>
@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('transactions')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('transactions')}}</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('filters') }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.transactions.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="account_type"  class="form-control select2 w-100" id="account_type" >
                                            <option value="">{{ trans('select_account_type') }}</option>
                                            <option value="user">{{ trans('user') }}</option>
                                            <option value="branch">{{ trans('branch') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="users">
                                        <select name="user_id"  class="form-control select2 w-100" id="user_id">
                                            <option value="">{{ trans('select_user') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" >{{ $user->first_name." ".$user->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="branches">
                                        <select name="branch_id"  class="form-control select2 w-100" id="branch_id">
                                            <option value="">{{ trans('select_branch') }}</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" >{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
                                <span class="table-add float-right">
                                    <a href="{{route('admin.transactions.export', array_merge(request()->all(['vendor_id','from_date','to_date'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    <a href="{{ route('admin.settle.create') }}" class="btn btn-icon"><i class="fa fa-dollar fa-1x" aria-hidden="true"></i></a>
                                    @can("create", Transaction::class)
{{--                                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>--}}
                                    @endcan
                                </span>
                                <h4>
                                    {{trans('transactions_list')}}
                                    @if($totalBalance)
                                        ( {{ trans('total_balance') }} <span class="badge badge-success">{{ $totalBalance }}</span>)
                                    @else
                                        ( {{ trans('num_rows') }} <span class="badge badge-success">{{ $count }}</span>)
                                    @endif
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
                                                <th>{{ trans('debit') }}</th>
                                                <th>{{ trans('credit') }}</th>
                                                <th>{{ trans('balance') }}</th>
                                                <th>{{ trans('order_id') }}</th>
                                                <th>{{ trans('order_type') }}</th>
                                                <th>{{ trans('transaction_type') }}</th>
                                                <th>{{ trans('description') }}</th>
                                                <th>{{ trans('created_date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $transaction)
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                @if($transaction->accountable_type == 'App\Models\User')
                                                    <td>{{ $transaction->accountable->first_name." ".$transaction->accountable->last_name }}</td>
                                                @elseif($transaction->accountable_type == 'App\Models\Branch')
                                                    <td>{{ $transaction->accountable->name }}</td>
                                                @endif
                                                <td>{{ $transaction->debit}}</td>
                                                <td>{{ $transaction->credit }}</td>
                                                <td>{{ $transaction->balance }}</td>
                                                <td>{{ $transaction->order_id }}</td>
                                                <td>{{ $transaction->order ? OrderTypes::getOne($transaction->order->type): '-'  }}</td>
                                                <td>{{ TransactionTypes::getOne($transaction->transaction_type) }}</td>
                                                <td>{{ $transaction->description }}</td>
                                                <td>{{ $transaction->created_at }}</td>
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
            $('#branches').show();

            if($(this).val() == 'user'){
                $('#users').show();
                $('#branches').hide();
            }
        });

        $('#user_id').on('change', function(){
            $('#account_id').val($(this).val());
        });

        $('#branch_id').on('change', function(){
            $('#account_id').val($(this).val());
        });

    </script>
@endsection
