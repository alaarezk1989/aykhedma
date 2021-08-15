@extends('admin.layout')

@section('content')

    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('dashboard') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('dashboard') }}</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-6 col-xl-4 col-sm-12 col-md-6">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-primary mr-3">
                                <i class="fa ti ti-headphone-alt"></i>
                            </span>
                            <div>
                                <h4 class="m-0"><strong>{{ $tickets['submitted'] }}</strong></h4>
                                <h6 class="mb-0">{{ trans("submitted_tickets") }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 col-sm-12 col-md-6">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-orange mr-3">
                                <i class="fa fa-clock-o"></i>
                            </span>
                            <div>
                                <h4 class="m-0"><strong>{{  $tickets['pending'] }}</strong></h4>
                                <h6 class="mb-0">{{ trans('pending') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-4 col-sm-12 col-md-6">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <span class="stamp stamp-md bg-warning mr-3">
                                <i class="fa fa-check"></i>
                            </span>
                            <div>
                                <h4 class="m-0"><strong>{{ $tickets['resolved'] }}</strong></h4>
                                <h6 class="mb-0">{{ trans('resolved') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!--row open-->
            <div class="row">
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="card-order">
                                <h6 class="mb-2"> {{ trans('orders_count') }}</h6>
                                <h2 class="text-right"><i
                                        class="fa fa-cart-plus mt-2 float-left"></i><span>{{ $orders['totalOrders'] }}</span>
                                </h2>
                                {{--                                <p class="mb-0">Monthly Orders<span class="float-right">835</span></p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="card-widget">
                                <h6 class="mb-2">{{ trans("orders"). ' '.trans('submitted') }}</h6>
                                <h2 class="text-right"><i
                                        class="fa fa-credit-card mt-2 float-left"></i><span>{{ $orders['submitted'] }}</span>
                                </h2>
                                {{--                                <p class="mb-0">Monthly Income<span class="float-right">$7,893</span></p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="card-widget">
                                <h6 class="mb-2">{{ trans("orders"). ' '.trans('cancelled') }}</h6>
                                <h2 class="text-right"><i
                                        class="fa fa-paper-plane mt-2 float-left"></i><span>{{ $orders['cancelled'] }}</span>
                                </h2>
                                {{--                                <p class="mb-0">Monthly Sales<span class="float-right">3,756</span></p>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="card-widget">
                                <h6 class="mb-2">{{ trans("orders"). ' '.trans('delivered') }}</h6>
                                <h2 class="text-right"><i
                                        class="fa fa-line-chart mt-2 float-left"></i><span>{{ $orders['delivered'] }}</span>
                                </h2>
                                {{--                                <p class="mb-0">Monthly Profit<span class="float-right">$4,678</span></p>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--row closed-->


            <!--row open-->
            <div class="row">
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-cyan text-white ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="icon1 text-center">
                                        <i class="ion-ios-people-outline"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-center">
                                        <span class="text-white">{{ trans("customers") }}</span>
                                        <h2 class="text-white mb-0">{{ $users['customers'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="icon1 text-center">
                                        <i class="ion-ios-pie-outline"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-center">
                                        <span class="text-white">{{ trans("vendors") }}</span>
                                        <h2 class="text-white mb-0">{{ $users['vendors'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-orange text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="icon1 text-center">
                                        <i class="ion-ios-people-outline"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-center">
                                        <span class="text-white">{{ trans("public_driver") }}</span>
                                        <h2 class="text-white mb-0">{{ $users['publicDrivers'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-12">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="icon1 text-center">
                                        <i class="ion-ios-people-outline"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-center">
                                        <span class="text-white">{{ trans("delivery_person") }}</span>
                                        <h2 class="text-white mb-0">{{ $users['deliveryPerson'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--row closed-->


        </section>

    </div>
@stop
