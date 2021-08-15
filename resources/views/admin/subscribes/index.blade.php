@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('subscribes') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('subscribes') }}</li>
                </ol>
            </div>
            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    @can("create", Subscribe::class)
                                    <a href="{{ route('admin.subscribes.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{ trans('subscribes_list') }}</h4>
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
                                                <th>{{ trans('type') }}</th>
                                                <th>{{ trans('segmentation') }}</th>
                                                <th>{{ trans('banner') }}</th>
                                                <th>{{ trans('title') }}</th>
                                                <th>{{ trans('body') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $subscribe)
                                            <tr>
                                                <td>{{ $subscribe->id }}</td>
                                                <td>{{ \App\Constants\NotificationTypes::getOne($subscribe->type) }}</td>
                                                <td>{{ $subscribe->segmentation ? $subscribe->segmentation->title: '-' }}</td>
                                                <td> @if($subscribe->banner)<img style="width: 100px" src="{{ asset($subscribe->banner) }}">@else - @endif</td>
                                                <td>{{ $subscribe->title }}</td>
                                                <td>{{ $subscribe->body }}</td>
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
