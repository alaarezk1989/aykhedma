@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('subscribes')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subscribes.index') }}" class="text-light-color">{{trans('subscribes')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_subscribe')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.subscribes.store') }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="form-group col-md-4" id="type">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('type')}} *</label>
                                            <select name="type"  class="form-control select2 w-100" id="type">
                                                <option value="" selected>{{ trans('select_type') }}</option>
                                                @foreach(\App\Constants\NotificationTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ $key == old( 'type') ? "selected":null }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="segmentation_id">{{trans('segmentation')}} *</label>
                                        <select name="segmentation_id"  class="form-control select2 w-100">
                                            <option value="">{{ trans('select_segmentation') }}</option>
                                            @foreach($segmentations as $segmentation)
                                                <option value=" {{$segmentation->id}}" {{ old('segmentation_id') == $segmentation->id ? 'selected': null }}>{{ $segmentation->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="title">{{trans('title')}} *</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="body">{{trans('body')}} *</label>
                                        <textarea class="form-control" name="body" rows="5">{{ old('body') }}</textarea>
                                    </div>
{{--                                    <div class="form-group col-md-4">--}}
{{--                                        <label for="banner">{{trans('banner')}}</label>--}}
{{--                                        <input type="file" name="banner" >--}}
{{--                                    </div>--}}
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
