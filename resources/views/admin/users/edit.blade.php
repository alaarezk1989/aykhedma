@extends('admin.layout')

@section('content')
<?php

use \App\Constants\GenderTypes;
use \App\Constants\UserTypes;
use \App\Constants\ClassTypes;
?>
<div class="app-content">
    <section class="section">

        <!--page-header open-->
        <div class="page-header">
            <h4 class="page-title">{{trans('users')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-light-color">{{trans('users')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('update_user')}}</li>
            </ol>
        </div>
        <!--page-header closed-->

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('update_user')}}</h4>
                        </div>
                        <div class="card-body">
                            @include('admin.errors')
                            <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="Post" enctype="multipart/form-data" autocomplete="off" >
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id}}" />


                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">{{trans('first_name')}} *</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ !(old('first_name'))? $user->first_name : old('first_name' )}}" >
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="last_name">{{trans('last_name')}} *</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ !(old('last_name'))? $user->last_name : old('last_name') }}" >
                                    </div>
                                </div>

                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-6">
                                        <label for="email">{{trans('email')}} </label>
                                        <input type="email" class="form-control" name="email" id="email"  value="{{ !(old('email'))? $user->email : old('email') }}" >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="phone">{{trans('phone')}} *</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control"  name="phone" id="phone"  value="{{ !(old('phone'))? $user->phone : old('phone') }}" data-inputmask='"mask": "99999999999"' data-mask >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-4">
                                        <label for="birthdate">{{trans('birth_date')}}</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right dateFrom" name="birthdate" id="birthdate" value="{{ !(old('birthdate'))? $user->birthdate : old('birthdate') }}" >
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="password">{{trans('password')}}</label>
                                        <input type="password" class="form-control" name="password" id="password"  >
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="password_confirmation">{{trans('password_confirmation')}}</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" >
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="class">{{trans('class')}}</label>
                                            <select name="class"  class="form-control select2 w-100" style="width: 100%">
                                                <option value="">{{ trans('select_class') }}</option>
                                                @foreach(ClassTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ $user->class == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="company_id">{{trans('company')}}</label>
                                            <select name="company_id"  class="form-control select2 w-100" style="width: 100%">
                                                <option value="">{{ trans('select_company') }}</option>
                                                @foreach($companies as $company)
                                                    <option value="{{$company->id}}" {{ $user->company_id == $company->id ? "selected":null }} >{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label for="types">{{trans('user_type')}} *</label>
                                            <select name="type"  class="form-control select2 w-100" id="types" style="width: 100%">
                                                <option value="">{{ trans('select_user_type') }}</option>
                                                @foreach(UserTypes::getList() as $key => $value)
                                                <option value="{{ $key }}" {{ $user->type == $key ? "selected":null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" @if(!in_array($user->type, [UserTypes::VENDOR, UserTypes::DRIVER])) style="visibility:hidden;" @endif id="vendor">
                                        <div class="form-group overflow-hidden">
                                            <label for="vendor_id">{{trans('vendor')}}</label>
                                            <select name="vendor_id"  class="form-control select2 w-100" id="vendor_id" style="width: 100%">
                                                <option value="">{{ trans('select_vendor') }}</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}" {{ $user->vendor_id == $vendor->id ? "selected":null }}>{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" @if($user->type !=  UserTypes::DRIVER) style="visibility:hidden;" @endif  id="branch">
                                        <div class="form-group overflow-hidden">
                                            <label for="branch_id">{{trans('branch')}}</label>
                                            <select name="branch_id" class="form-control select2 w-100" id="branch_id" style="width: 100%">
                                                @if($user->type == UserTypes::DRIVER)
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}"   @if($user->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" @if($user->type !=  UserTypes::ADMIN && $user->type !=  UserTypes::PUBLIC_DRIVER)style="visibility:hidden;"@endif id="branches">
                                        <div class="form-group overflow-hidden">
                                            <label for="branches">{{trans('branches')}}</label>
                                            <select multiple name="branches[]" class="form-control select2 w-100" id="branches" style="width: 100%">
                                                @foreach($branchesPermissions as $branch)
                                                    @if($user->type == UserTypes::ADMIN )
                                                        <option value="{{ $branch->id }}" @if(!old('branches')){{in_array($branch->id, $userBranchesPermissions) ? "selected":null }}@else {{ in_array( $branch->id, (array)old('branches')) ? "selected":null }} @endif>{{ $branch->name }}</option>
                                                    @endif
                                                    @if($user->type == UserTypes::PUBLIC_DRIVER )
                                                        <option value="{{ $branch->id }}" @if(old('branches')) {{ in_array($branch->id, (array)old('branches')) ? "selected" : null }} @elseif($user->publicDriverBranches->containsStrict('id', $branch->id)) selected @endif>{{ $branch->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <div class="col-md-4">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ $user->active ? 'checked' : '' }} class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group custom-switches-stacked">
                                            <label class="form-label">{{trans('gender')}}</label>
                                            <label class="custom-switch">
                                                <input type="radio" name="gender" value="{{GenderTypes::MALE}}" class="custom-switch-input" {{ (old('gender',$user->gender)== GenderTypes::MALE) ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{trans('male')}}</span>
                                            </label>
                                            <label class="custom-switch">
                                                <input type="radio" name="gender" value="{{GenderTypes::FEMALE}}" class="custom-switch-input" {{ (old('gender',$user->gender)==GenderTypes::FEMALE) ? 'checked' : '' }} >
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description">{{trans('female')}}</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <p style ="margin-top:-30px ">{{trans('profile_picture')}}</p>
                                        <label class="custom-switch" class="text-center" style ="margin-right:90px ">
                                            <input type="file"  name="image" onchange="readURL(this,'upload_img');"  class="image"style="visibility: hidden">
                                            <img id="upload_img"  src="{{ asset($user->image)}}" style ="width:100px;height:100px; border-radius:50px; margin-top:-10px ;margin-right:70px ;">
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i> {{trans('save')}}</button>
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
@section('scripts')
<script>
  $('#types').on('change', function () {
            $('#vendor').css('visibility','hidden');
            $('#branches').css('visibility','hidden');
            $('#vendor').val(null);

            if (this.value === '{{ UserTypes::VENDOR }}') {
                $('#vendor').css('visibility','visible');
                $('#branch').css('visibility','hidden');

            }
            if( this.value === '{{ UserTypes::DRIVER }}' )
            {
                $('#vendor').css('visibility','visible');
                $('#branch').css('visibility','visible');
            }
            if( this.value === '{{ UserTypes::NORMAL }}' )
            {
                $('#vendor').css('visibility','hidden');
                $('#branch').css('visibility','hidden');
            }
            if( this.value === '{{ UserTypes::PUBLIC_DRIVER }}' )
            {
                $('#vendor').css('visibility','hidden');
                $('#branch').css('visibility','hidden');
            }
           if( this.value === '{{ UserTypes::ADMIN }}' )
           {
               $('#branches').css('visibility','visible');
           }
        });

        $('#vendor_id').on('change', function(){
                var vendor_id = $(this).val();

                var html = '<option value ="">{{ trans("select_branch") }}</option>';
                $.ajax({
                    url: '{{ route("api.vendors.branches") }}',
                    type: 'get',
                    data: {_token: '{{ csrf_token() }}', 'vendor_id': vendor_id},

                    success: function (data) {
                        // $('#branch').css('visibility','visible');
                        console.log(data);
                        var i;
                        for (i = 0; i < data.length; i++) {
                            html +='<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#branch_id').html(html);
                    },
                    error: function () {
                        alert('error');
                    }
                });
            });

</script>
@stop
