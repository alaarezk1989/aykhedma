@extends('web.auth.base')

@section('auth.content')
    <div class="col-lg-6">
        <div class="usercontent">
            <div class="row">
                <div class="col-12">
                    <h2>{{ trans("forget_password") }}</h2>
                </div>
                <form action="{{ route('web.auth.reset.confirm') }}"  method="post" class="col-md-8" >
                    @csrf
                    <div class="row">
                        @if(session()->has('error'))
                            <div class="col-12">
                                <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                    <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        <div class="alert-title">{{trans('error')}}</div>
                                        {{ session('error') }}
                                    </div>
                                </div>
                            </div>
                        @elseif(session()->has('success'))
                            <div class="col-12">
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
                            </div>
                        @endif
                            <input type="hidden" name="email" value="{{ request('email') }}">
                            <input  class="btn-block" name="token" type="hidden" value="{{ request('token') }}" />
                        <div class="col-12">
                            <label for="password">@error('password'){{ $message }}@enderror</label>
                            <input class="btn-block" name="password" type="password" placeholder="{{ trans("password") }}" />
                        </div>
                        <div class="col-12">
                            <label for="password_confirmation">@error('password_confirmation'){{ $message }}@enderror</label>
                            <input class="btn-block" name="password_confirmation" type="password" placeholder="{{ trans("password_confirmation") }}" />
                        </div>
                        <div class="col-12">
                            <button  type="submit" class="btn btn-block">{{ trans("edit_password") }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
