@extends('web.auth.base')

@section('auth.content')
    <div class="col-lg-6">
        <div class="usercontent">
            <div class="row">
                <div class="col-12">
                    <h2>{{trans('new_account')}} </h2>
                </div>
                <form action="{{ route('web.auth.register') }}"  method="post" class="col-8">
                {{ csrf_field() }}
                    <div class="row">
                    @if(count($errors))
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
                        <div class="col-12">
                            <label for="first_name">@error('first_name'){{ $message }}@enderror</label>
                           <input class="btn-block" type="text" name="first_name" placeholder="{{trans('first_name')}}" value="{{old('first_name')}}">
                        </div>
                        <div class="col-12">
                            <label for="first_name">@error('last_name'){{ $message }}@enderror</label>
                            <input class="btn-block" type="text" name="last_name" placeholder="{{trans('last_name')}}" value="{{old('last_name')}}">
                        </div>
                        <div class="col-12">
                            <label for="first_name">@error('user_name'){{ $message }}@enderror</label>
                            <input class="btn-block" type="text" name="user_name" placeholder="{{trans('user_name')}}" value="{{old('user_name')}}">
                        </div>

                        <div class="col-12">
                            <label for="first_name">@error('email'){{ $message }}@enderror</label>
                            <input class="btn-block" type="text" name="email" placeholder="{{trans('email')}}" value="{{old('email')}}">
                        </div>
                        <div class="col-12">
                            <label for="first_name">@error('password'){{ $message }}@enderror</label>
                            <input class="btn-block" type="password" name="password" placeholder="{{trans('password')}}" value="{{old('password')}}">
                        </div>
                        <div class="col-12">
                            <label for="first_name">@error('confirm_password'){{ $message }}@enderror</label>
                            <input class="btn-block" type="password" name="confirm_password" placeholder="{{trans('confirm_password')}}" value="{{old('confirm_password')}}">
                        </div>
                        <div class="col-6 pl-0">
                            <label class="check text-right">
                                <input class="mr-4" type="radio" name="gender" value="1" placeholder="" checked>
                                <span>{{trans("male")}}</span>
                            </label>
                        </div>
                        <div class="col-6 pr-0">
                            <label class="check text-right">
                                <input class="mr-4" type="radio" name="gender" value="0" placeholder="">
                                <span>{{trans("female")}}</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-block btn-sign">{{trans('register')}}</button>
                        </div>

                        <div class="col-12 text-center" style="margin-top:15px;">
                            <h4>{{trans('or')}}</h4>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5">
                                    <p>{{trans('register_via')}}</p>
                                </div>
                                <div class="col-3">
                                    <a href="#">
                                        <img src="/assets/img/Icons/facebook.png">
                                    </a>
                                </div>
                                <div class="col-3">
                                    <a href="#">
                                        <img src="/assets/img/Icons/google.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
