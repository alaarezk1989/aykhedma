@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('companies')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('companies')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" type="get" action="{{ route("admin.companies.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('name') }}" class="form-control" value="{{ request("name") }}" name="name" >
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-1 mb-0">{{ trans("search") }}</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    @can("create", Company::class)
                                        <a href="{{ route('admin.companies.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                                <h4>{{trans('companies_list')}}</h4>
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
                                @if(session()->has('delete'))
                                    <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                        <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>×</span>
                                            </button>
                                            <div class="alert-title">Success</div>
                                            {{ session('delete') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 1px"> # </th>
                                                <th> {{trans('name')}} </th>
                                                <th style="width: 5px"> {{trans('phone')}} </th>
                                                <th style="width: 5px"> {{trans('mobile')}} </th>
                                                <th> {{trans('email')}} </th>
                                                <th> {{trans('administrator')}} </th>
                                                <th> {{trans('address')}} </th>
                                                <th> {{trans('activity')}} </th>
                                                <th style="width: 5px"> {{trans('commercial_registration_no')}} </th>
                                                <th style="width: 5px"> {{trans('tax_card')}} </th>
                                                <th> {{trans('other')}} </th>
                                                @if(auth()->user()->hasAccess("admin.compamies.update") || auth()->user()->hasAccess("admin.companies.destroy"))
                                                <th style="width: 1px"> {{ trans('actions') }} </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $company)
                                            <tr>
                                                <td>{{ $company->id }}</td>
                                                <td>{{ $company->name }}</td>
                                                <td>{{ $company->phone }}</td>
                                                <td>{{ $company->mobile }}</td>
                                                <td>{{ $company->email }}</td>
                                                <td>{{ $company->administrator }}</td>
                                                <td>{{ $company->address }}</td>
                                                <td>{{ $company->activity }}</td>
                                                <td>{{ $company->commercial_registration_no }}</td>
                                                <td>{{ $company->tax_card }}</td>
                                                <td>{{ $company->other }}</td>
                                                @if(auth()->user()->hasAccess("admin.companies.update") || auth()->user()->hasAccess("admin.companies.destroy") || auth()->user()->hasAccess("admin.companies.users"))
                                                <td>
                                                <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can("update", $company)
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.companies.edit', ['company' => $company]) }}"><i class="fa fa-edit"></i>{{ trans('edit') }}</a>
                                                            @endcan
                                                            @can("delete", $company)
                                                            <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $company->id }}">
                                                                <i class="fa fa-trash"></i> {{trans('remove')}}
                                                            </button>
                                                            @endcan
                                                            @can("users", $company)
                                                            <a class="dropdown-item has-icon" href="{{ route('admin.companies.users', ['company' => $company]) }}"><i class="fa fa-edit"></i> {{trans('users')}}</a>
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
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @foreach ($list as $company)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $company->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.companies.destroy', ['$company' => $company]) }}" method="Post" >
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">{{trans('close')}}</button>
                                <button type="submit" class="btn btn-primary">{{trans('delete')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop
