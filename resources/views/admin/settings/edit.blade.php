@extends('admin.layout')

@section('content')
<div class="app-content">
    <section class="section">

        <!--page-header open-->
        <div class="page-header">
            <h4 class="page-title">{{trans('settings')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}" class="text-light-color">{{trans('settings')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('update_setting')}} #{{ $setting->id }}</li>
            </ol>
        </div>
        <!--page-header closed-->

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('update_setting')}}</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.errors')
                            <form action="{{ route('admin.settings.update', ['setting' => $setting]) }}" method="post">
                                @method("PUT")
                                @csrf
                                <ul class="nav nav-tabs" role="tablist">
                                    @foreach(config()->get('app.locales') as $lang => $language)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $lang == app()->getLocale() ? 'active': ''}} show" id="home-tab2" data-toggle="tab" href="#lang-{{ $lang }}" role="tab" aria-controls="home" aria-selected="true">{{ trans($language) }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach(config()->get('app.locales') as $lang => $language)
                                    <div class="tab-pane fade {{ $lang == app()->getLocale() ? 'active show': ''}}" id="lang-{{ $lang }}" role="tabpanel" aria-labelledby="home-tab2">
                                        <div class="form-group col-md-4">
                                            <label for="name">{{trans('value')}} *</label>
                                            <input type="text" class="form-control" name="{{ $lang }}[value]" value="{{ !old( $lang.'.value') ? $setting->translate($lang)->value : old( $lang.'.value') }}" id="{{ $lang }}[name]">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="custom-switch">
                                        <input type="checkbox" name="active" value="1" {{ $setting->active ? 'checked' : '' }} class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">{{trans('active')}}</span>
                                    </label>
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
