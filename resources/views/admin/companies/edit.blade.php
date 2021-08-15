@extends('admin.layout')

@section('content')
<div class="app-content">
    <section class="section">

        <!--page-header open-->
        <div class="page-header">
            <h4 class="page-title">{{ trans('companies') }}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{ trans('home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.companies.index') }}" class="text-light-color">{{ trans('companies') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('update_companies') }} #{{ $company->id }}</li>
            </ol>
        </div>
        <!--page-header closed-->

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ trans('update_companies') }}</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.errors')
                            <form action="{{ route('admin.companies.update', ['company' => $company]) }}" method="Post"  >
                                @method('PUT')
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
                                                <label for="name">{{trans('name')}} *</label>
                                                <input type="text" class="form-control" name="{{ $lang }}[name]" value="{{ old($lang.".name", $company->translate($lang)->name)}}" id="{{ $lang }}[name]">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="address">{{trans('address')}}</label>
                                                <input type="text" class="form-control" name="{{ $lang }}[address]" value="{{ old($lang.".address", $company->translate($lang)->address)}}" id="{{ $lang }}[address]">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="activity">{{trans('activity')}}</label>
                                                <input type="text" class="form-control" name="{{ $lang }}[activity]" value="{{ old($lang.".activity", $company->translate($lang)->activity)}}" id="{{ $lang }}[activity]">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mobile">{{trans('mobile')}}</label>
                                    <input type="text" class="form-control" name="mobile" value="{{old('mobile', $company->mobile)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone">{{trans('phone')}} *</label>
                                    <input type="text" class="form-control" name="phone" value="{{old('phone', $company->phone)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">{{trans('email')}}</label>
                                    <input type="text" class="form-control" name="email" value="{{old('email', $company->email)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="administrator">{{trans('administrator')}}</label>
                                    <input type="text" class="form-control" name="administrator" value="{{old('administrator', $company->administrator)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="administrator_phone">{{trans('administrator_phone')}}</label>
                                    <input type="text" class="form-control" name="administrator_phone" value="{{old('administrator_phone', $company->administrator_phone)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="administrator_email">{{trans('administrator_email')}}</label>
                                    <input type="text" class="form-control" name="administrator_email" value="{{old('administrator_email', $company->administrator_email)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="administrator_job">{{trans('administrator_job')}}</label>
                                    <input type="text" class="form-control" name="administrator_job" value="{{old('administrator_job', $company->administrator_job)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="commercial_registration_no">{{trans('commercial_registration_no')}}</label>
                                    <input type="number" min="0" class="form-control" name="commercial_registration_no" value="{{old('commercial_registration_no', $company->commercial_registration_no)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tax_card">{{trans('tax_card')}}</label>
                                    <input type="text" class="form-control" name="tax_card" value="{{old('tax_card', $company->tax_card)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="other">{{trans('other')}}</label>
                                    <textarea class="form-control" rows="4" cols="50" name="other" id="other" >{{ old("other", $company->other) }}</textarea>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i> {{ trans('save') }}</button>
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
