@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('tickets') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('tickets') }}</li>
                </ol>
            </div>
            {{-- filter --}}
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('filter_by')}}</h4>
                        </div>
                        <div class="card-body">
                            <form  class="form-horizontal" method="get"  action="{{ route("admin.tickets.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="filter_by" class="form-control select2 w-100" id="filter_by" >
                                            <option value=""  selected>{{ trans('filter_by') }}</option>
                                            <option value="user_id" {{ request("filter_by") == 'user_id' ? "selected":null }}>{{trans('user')}}</option>
                                            <option value="assignee_id" {{ request("filter_by") == 'assignee_id' ? "selected":null }}>{{trans('assignee')}}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="q" placeholder="{{trans("keyword")}}"  value="{{ request("q") }}" class="form-control" id="filteration" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="status"  class="form-control select2 w-100" id="status" >
                                            <option value="" >{{ trans('select_status') }}</option>
                                            @foreach($status as $key =>$value)
                                                <option value="{{ $key }}" {{ request("status") == $key ? "selected":null }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <select name="assignee" class="form-control select2 w-100" id="assignee" >
                                            <option value=" ">{{ trans('select_assignee') }}</option>
                                            <option value="1" {{ request("assignee") == '1'? "selected":null }}>{{trans('assigned')}}</option>
                                            <option value="null" {{ request("assignee") == 'null' ? "selected":null }}>{{trans('Not-assigned')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row date">

                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('from_date') }}" class="form-control dateFrom" id="date-picker-example" value="{{ request("from_date") }}" name="from_date" readonly>
                                    </div>

                                    <div class="col-md-3 input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" placeholder="{{ trans('to_date') }}" class="form-control dateTo" value="{{ request("to_date") }}" name="to_date" readonly>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary mt-1 mb-0">{{ trans("search") }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--page-header closed-->
            <div class="section-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="table-add float-right">
                                    <a href="{{route('admin.tickets.export', array_merge(request()->all(['status','assignee','from_date','to_date','filter_by','filteration'])))}}" class="btn btn-icon"><i class="fa fa-file-excel-o"></i></a>
                                    @can('create', Ticket::class)
                                        <a href="{{ route('admin.tickets.create') }}" class="btn btn-icon"><i class="fa fa-plus fa-1x" aria-hidden="true"></i></a>
                                    @endcan
                                </span>
                            <h4>{{ trans('tickets_list') }} <span class="badge badge-pill badge-success">{{$ticketsCount}}</span></h4>
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
                                                <th>{{ trans('title') }}</th>
                                                <th>{{ trans('assignee') }}</th>
                                                <th>{{ trans('date') }}</th>
                                                <th>{{ trans('status') }}</th>
                                                @if(auth()->user()->hasAccess("admin.tickets.update") || auth()->user()->hasAccess("admin.tickets.destroy"))
                                                    <th style="width: 1px">{{ trans('actions') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list as $ticket)
                                            <tr>
                                                <td>{{ $ticket->id }}</td>
                                                <td> <a href="{{ route('admin.ticket.details', ['ticket' => $ticket->id]) }}">{{ $ticket->title?? '-' }}</a></td>
                                                <td>{{ $ticket->assignee ? $ticket->assignee->first_name." ".$ticket->assignee->last_name : '-' }}</td>
                                                <td>{{ $ticket->created_at }}</td>
                                                <td><span class="badge badge-{{ $ticket->status == 1 ? 'danger' : 'success' }}">{{ $ticket->status == 1 ?  trans('pending')  :  trans('resolved')  }}</span></td>
                                                @if(auth()->user()->hasAccess("admin.tickets.update") || auth()->user()->hasAccess("admin.tickets.destroy"))
                                                <td>
                                                    <div class="btn-group dropdown">
                                                        <button type="button" class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa-cog fa"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @can("update", $ticket)
                                                                <a class="dropdown-item has-icon" href="{{ route('admin.tickets.edit', ['ticket' => $ticket->id]) }}"><i class="fa fa-edit"></i> {{trans('edit') }}</a>
                                                            @endcan
                                                            @can("delete", $ticket)
                                                            <button type="button" class="dropdown-item has-icon" data-toggle="modal" data-target="#delete_model_{{ $ticket->id }}">
                                                                <i class="fa fa-trash"></i> {{trans('remove') }}
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
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @foreach ($list as $ticket)
            <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $ticket->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.tickets.destroy', ['ticket' => $ticket]) }}" method="Post" >
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
            <!-- Message Modal closed -->
        @endforeach
    </div>
@stop
