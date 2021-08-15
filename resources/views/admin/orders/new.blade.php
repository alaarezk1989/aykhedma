@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">
            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('orders')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" class="text-light-color">{{trans('orders')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <span style="float:right">
                                    @can("create", User::class)

                                    @endcan
                                </span>
                                <h4>{{trans('new_order')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.orders.store') }}" method="post" autocomplete="off">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>
                                                {{trans('users')}}
                                                <a href="{{ route('admin.users.create') }}" target="_blank" class="btn  btn-outline-primary m-b-5  m-t-5" @if(app()->getLocale() == 'en')style=" margin-left: 130px" @else style=" margin-right: 72px" @endif>
                                                    <i class="fa fa-plus fa-1x" aria-hidden="true"></i> {{ trans('new_user') }}
                                                </a>
                                            </label>
                                            <select name="user_id"  class="form-control select2 w-100" id="user_id" >
                                            <option value="">{{ trans('select_user') }}</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ old("user_id") == $user->id ? "selected":null }}>{{ $user->first_name." ".$user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="addresses">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('address')}} *</label>
                                            <select name="address_id"  class="form-control select2 w-100" id="address_id" >
                                            <option value="">{{ trans('select_address') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="type">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('type')}} *</label>
                                            <select name="type"  class="form-control select2 w-100" id="type">
                                                <option value="" selected>{{ trans('select_type') }}</option>
                                                @foreach(\App\Constants\OrderTypes::getList() as $key => $value)
                                                    <option value="{{ $key }}" {{ $key == old( 'type') ? "selected":null }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
@section('scripts')
<script>
    $('#user_id').on('change', function() {
        var user =  this.value;
        $.ajax({
                url: '{{ route("api.addresses.index") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}', 'user':user},

                success: function(data){
                    var html='<option value ="">{{ trans("select_address") }}</option>';
                    var i;
                    for(i=0;i<data.length;i++){
                        html+=
                        '<option value ="'+data[i].id+'">'+data[i].location.name+'</option>';
                    }
                    $('#address_id').html(html);
                },
                error: function(){
                    alert("error");
                }
        });
    });
</script>
@endsection
