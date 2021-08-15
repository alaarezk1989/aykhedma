@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('products')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <!--row open-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.products.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control browser-default custom-select">
                                            <option value="">{{ trans('filter_by') }}</option>
                                            <option
                                                value="name" {{ request("filter_by") == "name" ? "selected":null }}>{{ trans('name') }}</option>
                                            <option
                                                value="category_id" {{ request("filter_by") == "category_id" ? "selected":null }}>{{ trans('category_id') }}</option>
                                            <option
                                                value="branch_id" {{ request("filter_by") == "branch_id" ? "selected":null }}>{{ trans('branch_id') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('keyword') }}" class="form-control"
                                               value="{{ request("q") }}" name="q">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="branch_type" class="form-control browser-default custom-select"
                                                id="branch_type">
                                            <option value="" selected>{{ trans('select_branch_type') }}</option>
                                            @foreach($branchTypes as $key =>$value)
                                                <option
                                                    value="{{ $key }}" {{ request("branch_type") == $key ? "selected":null }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="bundle" class="form-control browser-default custom-select"
                                                id="bundle">
                                            <option value="" selected>{{ trans('select_type') }}</option>
                                            <option
                                                value="0" {{ (request()->has('bundle') && (request()->get('bundle')== 0)) ? "selected" : null }}>{{ trans('products') }}</option>
                                            <option
                                                value="1" {{ request("bundle") == 1 ? "selected" : null }}>{{ trans('bundle') }}</option>


                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('from_date') }}"
                                               class="form-control dateFrom" value="{{ request("from_date") }}"
                                               name="from_date" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_date") }}" name="to_date" readonly>
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
                                    <a href="{{route('admin.products.export', array_merge(request()->all(['filter_by','q','branch_type','from-date','to_date'])))}}"
                                       class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can("create", \App\Models\Product::class)
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-icon"><i
                                                class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>
                                    {{trans('products_list')}}
                                    (
                                    <small>{{ trans('num_rows') }}</small>
                                    <span class="badge badge-success">{{ $count }}</span>)
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
                                            <th>{{trans('category')}}</th>
                                            <th>{{trans('name')}}</th>
                                            <th>{{trans('description')}}</th>
                                            <th>{{trans('image')}}</th>
                                            <th style="width: 1px">{{trans('status')}}</th>
                                            @if(auth()->user()->hasAccess("admin.products.update") || auth()->user()->hasAccess("admin.products.destroy"))
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->category?$product->category->name:'-' }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ strlen($product->description) > 50 ? substr($product->description,0,50) . "..." : $product->description }}</td>
                                                <td><img style="width: 70px; height: 70px;"
                                                         src="{{ count($product->images) ? asset($product->images[0]->image) : null }}">
                                                </td>
                                                <td><span
                                                        class="badge badge-{{ $product->active ? 'success' : 'danger' }}">{{ $product->active? trans('active') : trans('disabled') }}</span>
                                                </td>

                                                @if(auth()->user()->hasAccess("admin.products.update") || auth()->user()->hasAccess("admin.products.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $product)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.products.edit', ['product' => $product->id]) }}">
                                                                        <i class="fa fa-edit"></i> {{trans('edit')}}
                                                                    </a>
                                                                @endcan
                                                                @can("delete", $product)
                                                                    <button type="button" class="dropdown-item has-icon"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_model_{{ $product->id }}">
                                                                        <i class="fa fa-trash"></i> {{trans('remove')}}
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
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    @foreach ($list as $product)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.products.destroy', ['product' => $product]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{trans('close')}}</button>
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
