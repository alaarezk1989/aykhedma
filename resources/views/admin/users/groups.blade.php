@extends('admin.layout')

@section('content')
<?php
$lang = app()->getLocale();
?>

<div class="app-content">
    <section class="section">

        <!--page-header open-->
        <div class="page-header">
            <h4 class="page-title">{{trans('manage_groups')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-light-color">{{trans('users')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('manage_groups')}}</li>
            </ol>
        </div>
        <!--page-header closed-->
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('manage_groups')}}</h4>
                        </div>
                        <div class="card-body">

                            @if(session()->has('success'))
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
                            @endif

                            @include('admin.errors')
                            <form action="{{ route('admin.users.groups.store', ['user' => $user]) }}" method="Post" enctype="multipart/form-data" autocomplete="off" >
                                @method('POST')
                                @csrf

                                <div class="form-group col-md-12 row">
                                    @foreach ($groups as $group)
                                    <div class="form-group mb-0 col-md-4">

                                        <label>
                                            <input type="checkbox" name="groups[]"  value="{{$group->id}}"  {{ ($user->groups->contains('id', $group->id)) ? 'checked' : '' }} >
                                            {{$group->translate($lang)->name}}
                                        </label>

                                    </div>
                                    @endforeach

                                </div>

                                <div class="form-group col-md-12 row">
                                    <div class="form-group col-md-3">
                                        <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5">
                                            <i class="fa fa-save"></i> {{trans('save')}}</button>
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
