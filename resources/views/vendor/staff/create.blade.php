@extends('vendor.layout')

@section('content')
    <?php
    use \App\Constants\UserTypes;
    ?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('staff')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.home.index') }}"
                                                   class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendor.staff.index') }}"
                                                   class="text-light-color">{{trans('staff')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_staff')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('vendor.errors')
                                <form action="{{ route('vendor.staff.store') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <label for="first_name">{{trans('first_name')}}</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                   value="{{ old('first_name') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="middle_name">{{trans('middle_name')}}</label>
                                            <input type="text" class="form-control" name="middle_name" id="middle_name"
                                                   value="{{ old('middle_name') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="last_name">{{trans('last_name')}}</label>
                                            <input type="text" class="form-control" name="last_name" id="last_name"
                                                   value="{{ old('last_name') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <label for="name">{{trans('name')}}</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                   value="{{ old('name') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="user_name">{{trans('user_name')}}</label>
                                            <input type="text" class="form-control" name="user_name" id="user_name"
                                                   value="{{ old('user_name') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email">{{trans('email')}}</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                   value="{{ old('email') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <label for="phone">{{trans('phone')}}</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                       value="{{ old('phone') }}" data-inputmask='"mask": "99999999999"'
                                                       data-mask>
                                            </div>


                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="birthdate">{{trans('birth_date')}}</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker"
                                                       name="birthdate" id="birthdate" value="{{ old('birthdate') }}">
                                            </div>

                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="image">{{trans('image')}}</label>
                                            <div class="input-group">
                                                <div class="col-xl-6 col-lg-12 col-md-12 userprofile">
                                                    <div class="userpic mb-2">
                                                        <img src="{{ url('/') }}/assets/img/avatar/avatar-3.jpeg" alt=""
                                                             class="userpicimg" id="upload_img">
                                                        <input type="file" name="image"
                                                               onchange="readURL(this, 'upload_img');">
                                                    </div>

                                                    <div class="text-center">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="types">{{trans('type')}}</label>
                                                <select name="type" class="form-control select2 w-100" id="types">
                                                    <option value="">{{ trans('select_user_type') }}</option>
                                                    <option value="{{ UserTypes::VENDOR }}">{{ trans('vendor') }}</option>
                                                    <option value="{{ UserTypes::DRIVER }}">{{ trans('driver') }}</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="password">{{trans('password')}}</label>
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label
                                                for="password_confirmation">{{trans('password_confirmation')}}</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                   id="password_confirmation">
                                        </div>
                                    </div>


                                    <div class="form-group col-md-4">

                                        <div class="form-group custom-switches-stacked">
                                            <label class="form-label">{{trans('gender')}}</label>
                                            <label class="custom-switch">
                                                <input type="radio" name="gender" value="1"
                                                       class="custom-switch-input" checked="">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{trans('male')}}</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="gender" value="0"
                                                       class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{trans('female')}}</span>
                                            </label>

                                        </div>
                                    </div>

                                    <input type="hidden" name="vendor_id" value="{{auth()->user()->vendor_id}}">
                                    <div class="form-group col-md-12">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>

                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-3">
                                            <button type="submit" href="#"
                                                    class="btn  btn-outline-primary m-b-5  m-t-5"><i
                                                    class="fa fa-save"></i> {{trans('save')}}</button>
                                        </div>
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

