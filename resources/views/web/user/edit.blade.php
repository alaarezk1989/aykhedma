@extends('web.layout')

@section('content')
    <?php
    use \App\Constants\GenderTypes;
    ?>
    <section class="userditels">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    @include('web.user.navbar')

                    <ul class="box-other list-unstyled m-0 p-0">
                        <li class="prsi prsi-active">
                            <a href="">
                                <img src="{{ url('assets/img') }}/Icons/settings_white.png">
                                {{trans('personal_data')}}
                            </a>
                        </li>
                        <li class="pass">
                            <a href="{{route('password.edit')}}">
                                <img src="{{ url('assets/img') }}/Icons/password_teal.png" alt="">
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

            <div class="col-lg-9">
                <div class="usercontent">
                    <div class="row">
                        <div class="col-12">
                            <h2>{{trans('personal_data')}}</h2>
                        </div>

                        @include('web.alerts')

                        <form class="col-lg-12" action="{{ route('profile.update') }}"
                              method="Post" enctype="multipart/form-data" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="uplode">
                                <div class="file-upload ">
                                    <input id="upload" class="file-upload__input" type="file" name="image"
                                           onChange="readURL(this)">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="first_name" class="btn-block"
                                           placeholder="{{trans('first_name')}}"
                                           value="{{ !(old('first_name'))? $user->first_name : old('first_name' )}}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="last_name" class="btn-block"
                                           placeholder="{{trans('last_name')}}"
                                           value="{{ !(old('last_name'))? $user->last_name : old('last_name') }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="phone" class="btn-block"
                                           placeholder="{{trans('phone')}}" id="phone"
                                           value="{{ !(old('phone'))? $user->phone : old('phone') }}"
                                           data-inputmask='"mask": "99999999999"' data-mask>
                                </div>
                                <div class="col-lg-3 ">
                                    <div class="compo">
                                        <input type="radio" name="gender" value="{{GenderTypes::MALE}}"
                                               id="male" {{ (old('gender',$user->gender)== GenderTypes::MALE) ? 'checked' : '' }} >
                                        <label for="male">{{trans('male')}}</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="compo">
                                        <input type="radio" name="gender" value="{{GenderTypes::FEMALE}}"
                                               id="female" {{ (old('gender',$user->gender)==GenderTypes::FEMALE) ? 'checked' : '' }} >
                                        <label for="female">{{trans('female')}}</label>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="birthdate" class="btn-block text-center datepicker"
                                           placeholder="{{trans('birth_date')}}" id="birthdate"
                                           value="{{ !(old('birthdate'))? $user->birthdate : old('birthdate') }}">
                                </div>

                                <div class="col-12">
                                    <h2 class="mt-3">العنوان الاساسي</h2>
                                </div>

                                <div class="col-lg-6">
                                    <select class="btn-block" name="" id="">
                                        <option value="">الدولة</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select class="btn-block" name="" id="">
                                        <option value="">المدينة</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <input class="btn-block" type="text" placeholder=" المنطقة">
                                </div>

                                <div class="col-lg-6">
                                    <input class="btn-block" type="text" placeholder="الحي ">
                                </div>

                                <div class="col-lg-3">
                                    <input class="btn-block" type="text" placeholder="شارع ">
                                </div>
                                <div class="col-lg-3">
                                    <input class="btn-block" type="text" placeholder="عقار ">
                                </div>
                                <div class="col-lg-3">
                                    <input class="btn-block" type="text" placeholder="دور ">
                                </div>
                                <div class="col-lg-3">
                                    <input class="btn-block" type="text" placeholder="شقة ">
                                </div>
                                <div class="col-lg-6 mr-auto">
                                    <button class="btn btn-block" type="submit">{{trans('save')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@stop
