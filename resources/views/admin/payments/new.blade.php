@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('payments')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}" class="text-light-color">{{trans('payments')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_payment')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.payments.store') }}" method="post">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <label for="amount">{{ trans('amount') }}</label>
                                        <input type="number"  value="{{ old('amount') }}" class="form-control" name="amount">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="order_id">{{ trans('order_id') }}</label>
                                        <input type="number"  value="{{ old('order_id') }}" class="form-control" name="order_id">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="coupon_id">{{ trans('coupon_id') }}</label>
                                        <input type="number"  value="{{ old('coupon_id') }}" class="form-control" name="coupon_id">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="voucher_id">{{ trans('voucher_id') }}</label>
                                        <input type="number"  value="{{ old('voucher_id') }}" class="form-control" name="voucher_id">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="discount_id">{{ trans('discount_id') }}</label>
                                        <input type="number"  value="{{ old('discount_id') }}" class="form-control" name="discount_id">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="taxes">{{ trans('taxes') }}</label>
                                        <input type="number"  value="{{ old('taxes') }}" class="form-control" name="taxes">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="fees">{{ trans('fees') }}</label>
                                        <input type="number"  value="{{ old('fees') }}" class="form-control" name="fees">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gateway">{{ trans('gateway') }}</label>
                                        <input type="text"  value="{{ old('gateway') }}" class="form-control" name="gateway">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gateway_reference">{{ trans('gateway_reference') }}</label>
                                        <input type="text"  value="{{ old('gateway_reference') }}" class="form-control" name="gateway_reference">
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
