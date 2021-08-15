@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('transactions')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}" class="text-light-color">{{trans('transactions')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_transaction')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.transactions.store') }}" method="post">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('account_type')}} *</label>
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
                                    <div class="form-group col-md-4">
                                        <label for="credit">{{ trans('credit') }}</label>
                                        <input type="number" min="0" id="credit"  value="{{ old('credit') }}" class="form-control" name="credit">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="debit">{{ trans('debit') }}</label>
                                        <input type="number" min="0" id="debit" value="{{ old('debit') }}" class="form-control" name="debit">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('order_number')}} </label>
                                            <select name="order_id"  class="form-control select2 w-100" id="order_id" >
                                                <option value="">{{ trans('select_order_number') }}</option>
                                                @foreach($orders as $order)
                                                    <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? "selected" : null }}>{{ $order->id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('invoice_number')}}</label>
                                            <select name="invoice_id"  class="form-control select2 w-100" id="invoice_id" >
                                                <option value="">{{ trans('select_invoice_number') }}</option>
                                                @foreach($payments as $payment)
                                                    <option value="{{ $payment->id }}" {{ old('invoice_id') == $payment->id ? "selected" : null }}>{{ $payment->invoice_number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="description">{{trans('description')}}</label>
                                        <textarea class="form-control" rows="4" cols="50" name="description" id="description" >{{ old("description") }}</textarea>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i> {{trans('save')}}</button>
                                    </div>
                                </form>
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

        $('#credit').keyup(function(){
            $('#debit').val('');
        });

        $('#debit').keyup(function(){
            $('#credit').val('');
        });
    </script>
@endsection
