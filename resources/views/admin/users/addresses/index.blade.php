@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('addresses')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-light-color">{{trans('users')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('addresses')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                     @can("create", Address::class)
                                          <a href="{{ route('admin.user.addresses.create' , ['user' => $user->id]) }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('addresses_list')}}</h4>
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

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 1px">#</th>
                                                <th>{{trans('location')}}</th>
                                                <th>{{trans('building')}}</th>
                                                <th>{{trans('street')}}</th>
                                                <th>{{trans('floor')}}</th>
                                                <th>{{trans('apartment')}}</th>
                                                @if(auth()->user()->hasAccess("admin.user.addresses.update") || auth()->user()->hasAccess("admin.user.addresses.destroy"))
                                                    <th style="width: 1px">{{trans('actions')}}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $address)
                                            <tr>
                                                <td>{{ $address->id }}</td>
                                                <td>{{ $address->location?$address->location->name:'-' }}</td>
                                                <td>{{ $address->building }} </td>
                                                <td>{{ $address->street }}</td>
                                                <td>{{ $address->floor }}</td>
                                                <td>{{ $address->apartment }}</td>

                                                @if(auth()->user()->hasAccess("admin.user.addresses.update") || auth()->user()->hasAccess("admin.user.addresses.destroy"))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                @can("update", $address)
                                                                 <a class="dropdown-item has-icon" href="{{ route('admin.user.addresses.edit', ['user'=>$address->user_id,'address' => $address->id]) }}"><i class="fa fa-edit"></i> {{trans('edit')}}</a>
                                                                @endcan
                                                                @can("delete", $address)
                                                                    <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $address->id }}">
                                                                        <i class="fa fa-trash"></i> {{trans('remove')}}
                                                                    </button>
                                                                @endcan

                                                            </div>
                                                        </div>

                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        @foreach ($list as $address)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $address->id }}" tabindex="-1" role="dialog"  aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{ trans('delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.user.addresses.destroy', ['user'=>$address->user_id, 'address' => $address->id]) }}" method="Post" >
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">

                            {{ trans('delete_confirmation_message') }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">{{ trans('close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ trans('delete') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Message Modal closed -->
        @endforeach

    </div>
@stop
