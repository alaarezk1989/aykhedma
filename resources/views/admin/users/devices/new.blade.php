@extends('admin.layout')

@section('content')
<?php
    use \App\Constants\DeviceOS;
?>
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('user_devices')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.user.devices.index', ['user' => $user->id]) }}" class="text-light-color">{{trans('user_devices')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_user_device')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.user.devices.store',['user'=>$user->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <div class="form-group col-md-6">
                                        <label for="model">{{ trans('model') }}</label>
                                        <input type="text" class="form-control" value="{{ old('model') }}" name="model" id="model" >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="os">{{trans('os')}}</label>
                                            <select name="os"  class="form-control select2 w-100" id="os" >
                                                <option value="">{{ trans('select_os') }}</option>
                                                @foreach(DeviceOs::getList() as $key => $value)
                                                    <option value="{{ $key }}" >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
@endsection

