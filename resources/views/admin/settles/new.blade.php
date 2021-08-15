@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('settle')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}" class="text-light-color">{{trans('transactions')}}</a></li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_settle')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.settle.store') }}" method="post">
                                    @csrf
                                    <div class="form-group col-md-4">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('account_type')}} *</label>
                                            <select name="account_type"  class="form-control select2 w-100" id="account_type" >
                                                <option value="">{{ trans('select_account_type') }}</option>
                                                <option value="user">{{ trans('user') }}</option>
                                                <option value="branch">{{ trans('branch') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="users">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('users')}}</label>
                                            <select name="user_id"  class="form-control select2 w-100" id="user_id">
                                                <option value="">{{ trans('select_user') }}</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" >{{ $user->first_name." ".$user->last_name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4" id="branches">
                                        <div class="form-group overflow-hidden">
                                            <label>{{trans('branches')}}</label>
                                            <select name="branch_id"  class="form-control select2 w-100" id="branch_id">
                                                <option value="">{{ trans('select_branch') }}</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" >{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="account_id" id="account_id" value=""/>
                                    <div class="form-group col-md-4">
                                        <input type="number" id="balance"  class="form-control" readonly style="display: none"/>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="credit">{{ trans('credit') }}</label>
                                        <input type="text" id="credit"  value="{{ old('credit') }}" class="form-control" name="credit">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="debit">{{ trans('debit') }}</label>
                                        <input type="text"  id="debit" value="{{ old('debit') }}" class="form-control" name="debit">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="description">{{trans('description')}}</label>
                                        <textarea class="form-control" rows="4" cols="50" name="description" id="description" >{{ old("description") }}</textarea>
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
        $('#account_type').on('change', function(){
            $('#account_id').val('');
            $('#users').hide();
            $('#branches').show();

            if($(this).val() == 'user'){
                $('#users').show();
                $('#branches').hide();
            }
        });

        $('#user_id').on('change', function(){
            $('#account_id').val($(this).val());
        });

        $('#branch_id').on('change', function(){
            $('#account_id').val($(this).val());
        });

        $('#credit').keyup(function(){
            $('#debit').val('');
        });

        $('#debit').keyup(function(){
            $('#credit').val('');
        });

        $('#user_id').on('change', function() {
            $.ajax({
                url: '{{ route("api.account.balance") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}','account_id':this.value, 'account_type': $('#account_type').val() },

                success: function(data){
                    $('#balance').show();
                    $('#balance').val(data.result);
                },
                error: function(){
                    alert("error");
                }
            });
        });
        $('#branch_id').on('change', function() {
            $.ajax({
                url: '{{ route("api.account.balance") }}',
                type: 'get',
                data: { _token: '{{ csrf_token() }}','account_id':this.value, 'account_type': $('#account_type').val() },

                success: function(data){
                    $('#balance').show();
                    $('#balance').val(data.result);
                },
                error: function(){
                    alert("error");
                }
            });
        });

    </script>
@endsection
