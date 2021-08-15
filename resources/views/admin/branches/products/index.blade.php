@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('branch_products')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.branches.index') }}" class="text-light-color">{{trans('branches')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('branch_products')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
{{--                                    <a href="{{ route('admin.branch.products.create' , ['branch' => $branch->id]) }}" class="btn btn-icon"><i class="fa fa-copy fa-1x" aria-hidden="true"></i></a>--}}
                                    <a class="btn btn-icon" data-toggle="modal" data-target="#copy_model">
                                        <i class="fa fa-copy fa-1x" aria-hidden="true"></i>
                                    </a>
                                    @can('create', [BranchProduct::class, $branch])
                                        <a href="{{ route('admin.branch.products.create' , ['branch' => $branch->id]) }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('branch_product_list')}}</h4>
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
                                @include('admin.errors')

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 1px">#</th>
                                                <th>{{trans('category')}}</th>
                                                <th>{{trans('product')}}</th>
                                                <th>{{trans('price')}}</th>
                                                <th>{{trans('discount')}}</th>
                                                <th>{{trans('discount_till')}}</th>
                                                <th style="width: 1px">{{trans('status')}}</th>
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $product)
                                                @php
                                                    $branchProduct = \App\Models\BranchProduct::find($product->pivot->id);
                                                @endphp
                                                <tr>
                                                    <td>{{ $product->pivot->id }}</td>
                                                    <td>{{ $product->category?$product->category->name: '-' }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->pivot->price }} </td>
                                                    <td>{{ $product->pivot->discount }}</td>
                                                    <td>{{ $product->pivot->discount_till }}</td>
                                                    <td><span class="badge badge-{{ $product->pivot->active ? 'success' : 'danger' }}">{{ $product->pivot->active? trans('active') : trans('disabled') }}</span></td>
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", [$branchProduct, $branch])
                                                                    <a class="dropdown-item has-icon" href="{{ route('admin.branch.products.edit', ['branch' => $branch, 'branchProduct' => $product->pivot->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                @endcan
                                                                @can("delete", [$branchProduct, $branch])
                                                                    <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $product->pivot->id }}">
                                                                        <i class="fa fa-trash"></i> {{trans('remove')}}
                                                                    </button>
                                                                @endcan
                                                                <a class="dropdown-item has-icon" href="{{ route('admin.product.reviews.index', ['product' => $product->pivot->id]) }}"><i class="fa fa-star"></i> {{trans('reviews')}}</a>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        @foreach ($list as $product)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $product->pivot->id }}" tabindex="-1" role="dialog"  aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{ trans('delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.branch.products.destroy', ['branch'=> $branch,'branchProduct' => $product->pivot->id]) }}" method="Post" >
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">

                            {{ trans('delete_confirmation_message') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">{{ trans('close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ trans('delete') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Message Modal closed -->
        @endforeach

        <!-- Message Modal -->
        <div class="modal fade" id="copy_model" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{ trans('copy_products') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.branch.products.copy', ['newBranch'=> $branch]) }}" method="Post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group col-md-12">
                                <div class="form-group overflow-hidden">
                                    <label for="old_branch">{{trans('branch')}}</label>
                                    <select name="old_branch"  class="form-control" id="old_branch" >
                                        <option value="">{{ trans('select_branch') }}</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old("old_branch") == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ trans('copy') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Message Modal closed -->
    </div>
@stop
