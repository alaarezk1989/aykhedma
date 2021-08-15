@extends('vendor.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('orders')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendor.orders.index') }}" class="text-light-color">{{trans('orders')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_order')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('vendor.orders.store') }}" method="post">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('users')}}</label>
                                            <select name="user_id"  class="form-control select2 w-100" id="user_id" >
                                            <option value="">{{ trans('select_user') }}</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ old("user_id") == $user->id ? "selected":null }}>{{ $user->first_name." ".$user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('branches')}}</label>
                                            <select name="branch_id"  class="form-control select2 w-100" id="branch_id" >
                                            <option value="">{{ trans('select_branch') }}</option>
                                                @foreach($branchList as $branch)
                                                    <option value="{{ $branch->id }}" {{ old("branch_id") == $branch->id ? "selected":null }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4" id="addresses" style="display:none">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('address')}}</label>
                                            <select name="address_id"  class="form-control select2 w-100" id="address_id" >
                                            <option value="">{{ trans('select_address') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="preferred_delivery_time">{{trans('preferred_delivery_time')}}</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o inputIcon"></i>
                                            </div>
                                            <input class="form-control timepicker" type="text" name="preferred_delivery_time" value="{{ old('preferred_delivery_time') }}">
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
                data: { _token: '{{ csrf_token() }}','user':user},

                success: function(data){
                    $('#addresses').show();
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
<script>
    $(document).ready(function(){
        $('input.timepicker').timepicker({});
        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>
@endsection
