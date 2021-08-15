@extends('admin.layout')
@section('content')
<?php
    use \App\Constants\TicketStatus;
?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('tickets')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tickets.index') }}" class="text-light-color">{{trans('tickets')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_ticket')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.tickets.store') }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="form-group col-md-6">
                                        <label for="title">{{trans('title')}}</label>
                                        <input id="title" type="text" class="form-control" name="title" value="{{old("title")}}">
                                        <input type="hidden" class="form-control" value="{{auth()->user()->id}}" name="user_id">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="assignee_id">{{trans('select_assignee')}}</label>
                                            <select name="assignee_id"  class="form-control select2 w-100" id="assignee_id" >
                                                <option value="">{{ trans('select_assignee') }}</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}" {{ old("assignee_id") == $admin->id ? "selected":null }}>{{ $admin->first_name." ".$admin->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-group overflow-hidden">
                                            <label for="status">{{trans('status')}}</label>
                                            <select name="status"  class="form-control select2 w-100" id="status" >
                                                <option value="">{{ trans('select_ticket_status') }}</option>
                                                @foreach(TicketStatus::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ old("status") == $key ? "selected":null}} >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="description">{{trans('description')}} *</label>
                                    <textarea  id="description" rows="4" class="form-control" name="description">{{old("description")}}</textarea>
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
@stop
