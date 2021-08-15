@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\ObjectTypes;
    ?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('logs') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('logs') }}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.logs.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('message') }}" class="form-control"
                                               value="{{ request("message") }}" name="message">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('user_id') }}" class="form-control"
                                               value="{{ request("user_id") }}" name="user_id">
                                    </div>

                                    <div class="col-md-3">
                                        <select name="object_type" class="browser-default custom-select"
                                                id="object_type">
                                            <option value="">{{ trans('select_object_type') }}</option>
                                            @foreach(ObjectTypes::getList() as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ request("object_type") == $key ? "selected":null }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <button type="submit"
                                                class="btn btn-primary mt-1 mb-0 col-12"> {{ trans("search") }} </button>
                                    </div>

                                </div>

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

                                <h4>{{ trans('logs_list') }}</h4>
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
                                            <th>{{ trans('user') }}</th>
                                            <th>{{ trans('object_type') }}</th>
                                            <th>{{ trans('message') }}</th>
                                            <th>{{ trans('date') }}</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $data)
                                            <tr>

                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->user_id .'#'. $data->user['email'] }}</td>
                                                <td>{{ ObjectTypes::getOne($data->object_type) }}</td>

                                                <td>{{  $data->user['email'] .' - '.
                                                trans($data->message) .' '. ObjectTypes::getOne($data->object_type).' - #'.$data->object_id}}</td>
                                                <td>{{ $data->created_at }}</td>

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
