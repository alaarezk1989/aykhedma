@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('reviews')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.vendor.reviews.index', ['vendor' => $vendor->id]) }}" class="text-light-color">{{trans('reviews')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_reviews')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.vendor.reviews.store',['vendor'=>$vendor->id]) }}" method="post">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('user')}}</label>
                                            <select name="user_id"  class="form-control select2 w-100" id="user_id" >
                                            <option value="">{{ trans('select_user') }}</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ old("user_id") == $user->id ? "selected":null }}>{{ $user->first_name." ".$user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="rate">{{ trans('rate') }}</label>
                                        <input type="number" min="1" max="5" class="form-control" value="{{ old('rate') }}" name="rate" id="rate" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="review">{{trans('review')}}</label>
                                        <textarea class="form-control" rows="4" cols="50" name="review" id="review" >{{ old("review") }}</textarea>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="published" value="1" checked class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('published')}}</span>
                                        </label>
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
