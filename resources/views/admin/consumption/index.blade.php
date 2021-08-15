@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('order_products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('consumption')}}</li>
                </ol>
            </div>
            <!--page-header closed-->


            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.consumption") }}">
                                <div class="form-group row">

                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control" value="{{ request("name") }}" name="name" >
                                    </div>

                                    <div class="col-md-3">
                                        <select name="category_id"  class="form-control select2 w-100" id="status" >
                                            <option value="" >{{ trans('select_category') }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request("category_id") == $category->id ? "selected":null }}>{{ $category->name }}</option>
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


            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    <a href="{{route('admin.consumption.export', array_merge(request()->all(['filter_by','q','status'])))}}" class="btn btn-icon">
                                        <i class="fa fa-file-excel-o"></i></a>

                                </span>
                                <h4>
                                    {{trans('consumption_list')}}
                                    (<small>{{ trans('num_rows') }}</small> <span class="badge badge-success">{{  $list->total() }}</span>)
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
                                            <th>{{trans('product')}}</th>
                                            <th>{{trans('category')}}</th>
                                            <th>{{trans('quantity')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $orderProduct)

                                            <tr>
                                                <td>{{ $orderProduct->product_id }}</td>
                                                <td>{{ $orderProduct->product->name }}</td>
                                                <td>{{ $orderProduct->category->name }} </td>
                                                <td>{{ $orderProduct->quantity }}</td>

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
