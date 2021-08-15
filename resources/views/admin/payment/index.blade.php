@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('checkout') }}</h4>
            </div>
            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <section class="order-info">
                                        <ul class="items">
                                        <span>
                                            <i class="icon icon-bag"></i>
                                            <label class="lead" for="">{{trans('your_order') }}</label>
                                        </span>


                                        </ul>
                                        <ul class="price">
                                        <span>
                                            <i class="icon icon-tag"></i>
                                            <label class="lead" for="">{{trans('price') }}</label>
                                        </span>

                                            <li>
                                                <span class="curreny">$</span> 1250
                                            </li>
                                        </ul>
                                    </section>
                                    <section class="actions">
                                        <a class="continue btn btn-success" id="btn_continue" href="#">{{trans('pay')}}</a>
                                    </section>
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
            $('#btn_continue').click(function () {
                var url = '{{ route('web.payment.route', ['r' => 'getPaymentPage']) }}';
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    data: {_token: '{{ csrf_token() }}', 'paymentMethod': 'creditcard'},
                    success: function (response) {
                        if (response.form) {
                            $('body').append(response.form);
                            $('#payfort_payment_form input[type=submit]').click();
                        }
                    },
                    error: function(){
                        alert("error");
                    }

                });
            });

    </script>
@stop
