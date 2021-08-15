@extends('web.auth.base')

@section('auth.content')
    <div class="col-lg-6">
        <div class="usercontent">
            <div class="row">
                <div class="col-12">
                    <h2>تسجيل الدخول</h2>
                </div>
                <form action="{{ route('web.auth.attempt') }}"  method="post" class="col-md-8" >
                    {{ csrf_field() }}
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
                        <div class="col-12">
                            <input class="btn-block" name="email" type="text" placeholder="{{trans('email')}}">
                        </div>
                        <div class="col-12">
                            <input class="btn-block" name="password" type="password" placeholder="{{trans('password')}}">
                        </div>
                        <div class="col-12">
                            <button  type="submit" class="btn btn-block">{{trans('login')}}</button>
                        </div>
                        <div class="col-12 text-center">
                            <h4>{{trans('or')}}</h4>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5">
                                    <p>{{trans("register_via")}}</p>
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
