@extends('web.layout')

@section('content')
    <?php
    use \App\Constants\GenderTypes;
    ?>
    <section class="editpassword">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 userditels">

                    @include('web.user.navbar')

                    <ul class="box-other list-unstyled m-0 p-0">
                        <li class="prsi">
                            <a href="{{route('profile.edit')}}">
                                <img src="{{ url('assets/img') }}/Icons/settings_purble.png">
                                {{trans('personal_data')}}
                            </a>
                        </li>
                        <li class="pass pass-active">
                            <a href="">
                                <img src="{{ url('assets/img') }}/Icons/password_white.png" alt="">
                                {{trans('password')}}
                            </a>
                        </li>
                    </ul>

                    <div class="selectbox">
                        <select class="btn-block" name="" id="">
                            <option>العربية</option>
                        </select>
                        <img src="{{ url('assets/img') }}/Icons/language_indigo.png">
                    </div>

                </div>
            </div>
            <div class="col-5">
                <div class="input-passwor">
                    <h2> {{trans('password')}}</h2>
                    <div class="row">

                        @include('web.alerts')

                        <form class="col-lg-12" action="{{ route('password.update') }}"
                              method="Post" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="col-12">
                                <input class="btn-block" type="password" name="current_password"
                                       placeholder=" {{trans('current_password')}}">

                                <label class="lbl-img">
                                    <img src="{{ url('assets/img') }}/Icons/done_green.png">
                                </label>

                            </div>
                            <div class="col-12">
                                <input class="btn-block new-pass" type="password" name="password"
                                       placeholder=" {{trans('new_password')}}">

                            </div>
                            <div class="col-12">
                                <input class="btn-block check-pass" type="password" name="password_confirmation"
                                       placeholder=" {{trans('confirm_new_password')}}">

                            </div>
                            <div class="col-12">
                                <button class="btn btn-submit btn-block"> {{trans('save')}}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@stop
