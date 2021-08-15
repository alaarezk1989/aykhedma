@extends('admin.layout')

@section('content')
<?php
use \App\Constants\ClassTypes;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('segmentations')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('segmentations')}}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.segmentations.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('title') }}" class="form-control" value="{{ request("title") }}" name="title" >
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
                                    @can("create", Segmentation::class)
                                        <a href="{{ route('admin.segmentations.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('segmentations_list')}}</h4>
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
                                            <th>{{trans('title')}}</th>
                                            <th>{{trans('user_class')}}</th>
                                            <th>{{trans('zone')}}</th>
                                            <th>{{trans('organization')}}</th>
                                            <th>{{trans('previous_orders_amount')}}</th>
                                            @if(auth()->user()->hasAccess("admin.segmentation.update") || auth()->user()->hasAccess("admin.segmentation.destroy"))
                                                <th style="width: 1px">{{trans('actions')}}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $segmentation)
                                            <tr>
                                                <td>{{ $segmentation->id }}</td>
                                                <td>{{ $segmentation->title }}</td>
                                                <th>{{ ClassTypes::getOne($segmentation->class) }}</th>
                                                <th>{{ $segmentation->location ? $segmentation->location->name : '-' }}</th>
                                                <td>{{ $segmentation->company ? $segmentation->company->name : '-' }}</td>
                                                <td>{{ $segmentation->orders_amount }}</td>
                                                @if(auth()->user()->hasAccess("admin.segmentation.update") || auth()->user()->hasAccess("admin.segmentation.destroy"))
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can("update", $segmentation)
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.segmentations.edit', ['segmentation' => $segmentation->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                            @endcan
                                                            @can("delete", $segmentation)
                                                            <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $segmentation->id }}">
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


    @foreach ($list as $segmentation)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $segmentation->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.segmentations.destroy', ['segmentation' => $segmentation]) }}" method="Post" >
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">

                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">{{trans('close')}}</button>
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

