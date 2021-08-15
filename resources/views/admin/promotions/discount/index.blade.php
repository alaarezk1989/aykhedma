@extends('admin.layout')

@section('content')

    <?php
    use \App\Constants\PromotionTypes;
    ?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{ trans('discounts') }}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-light-color">{{ trans('home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('discounts') }}</li>
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
                            <form class="form-horizontal" type="get" action="{{ route("admin.discounts.index") }}">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input type="text" placeholder="{{ trans('title') }}" class="form-control"
                                               value="{{ request("title") }}" name="title">
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
                                    @can("create", \App\Models\Discount::class)
                                        <a href="{{ route('admin.discounts.create') }}" class="btn btn-icon">
                                            <i class="fa fa-plus fa-1x" aria-hidden="true"></i>
                                        </a>
                                    @endcan

                                </span>
                                <h4>{{ trans('discounts_list') }}</h4>
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

                                @php
                                    // register all permissions of `action` drop down elements hear
                                $permissions = [
                                    "admin.discounts.update",
                                    "admin.discounts.delete",
                                ];
                                @endphp
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 1px">#</th>
                                            <th>{{ trans('name') }}</th>
                                            <th>{{ trans('value') }}</th>
                                            <th>{{ trans('type') }}</th>
                                            <th>{{ trans('minimum_order_price') }}</th>
                                            <th>{{ trans('usage_no') }}</th>
                                            <th>{{ trans('date_from') }}</th>
                                            <th>{{ trans('date_to') }}</th>

                                            <th style="width: 1px">{{ trans('status') }}</th>
                                            @if(auth()->user()->hasAccess($permissions))
                                                <th style="width: 1px">{{ trans('actions') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($list as $discount)
                                            <tr>
                                                <td>{{ $discount->id }}</td>
                                                <td>{{ $discount->title }}</td>
                                                <td>{{ $discount->value }}</td>
                                                <td>{{ PromotionTypes::getOne($discount->type) }}</td>
                                                <td>{{ $discount->minimum_order_price }}</td>
                                                <td>{{ $discount->usage_no }}</td>

                                                <td>{{ date('d-m-Y', strtotime($discount->from_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($discount->to_date)) }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{$discount->active ? 'success' : 'danger'}}">
                                                        {{$discount->active? trans('active') : trans('disabled')}}
                                                    </span>
                                                </td>
                                                @if(auth()->user()->hasAccess($permissions))
                                                    <td>
                                                        <div class="btn-group dropdown">
                                                            <button type="button"
                                                                    class="btn btn-sm btn-info m-b-5 m-t-5 dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="fa-cog fa"></i>
                                                            </button>
                                                            <div class="dropdown-menu">

                                                                @can("update", $discount)
                                                                    <a class="dropdown-item has-icon"
                                                                       href="{{ route('admin.discounts.edit', ['discount' => $discount->id]) }}">
                                                                        <i class="fa fa-edit"></i> {{trans('edit') }}
                                                                    </a>
                                                                @endcan

                                                                @can("delete", $discount)
                                                                    <button type="button" class="dropdown-item has-icon"
                                                                            data-toggle="modal"
                                                                            data-target="#delete_model_{{ $discount->id }}">
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

    @foreach ($list as $discount)
        <!-- Message Modal -->
            <div class="modal fade" id="delete_model_{{ $discount->id }}" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="example-Modal3">{{trans('delete')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.discounts.destroy', ['discount' => $discount]) }}" method="Post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">

                                {{trans('delete_confirmation_message')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success"
                                        data-dismiss="modal">{{trans('close')}}</button>
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
