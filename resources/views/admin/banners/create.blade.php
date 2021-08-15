@extends('admin.layout')

@section('content')
    <?php
    use \App\Constants\BannerTypes;
    ?>
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('banners')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}"
                                                   class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}"
                                                   class="text-light-color">{{trans('banners')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('new')}}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('new_user')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.banners.store') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group col-md-12 row">

                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="types">{{trans('type')}} *</label>
                                                <select name="type" class="form-control select2 w-100" id="types">
                                                    <option value="">{{ trans('select_type') }}</option>
                                                    @foreach(BannerTypes::getList() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old("type") == $key ? "selected":null }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-8">
                                            <label for="url">{{trans('url')}}</label>
                                            <input type="url" class="form-control" value="{{ old( 'url' ) }}" name="url" id="url">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-4">
                                            <label for="date_from">{{trans('date_from')}}</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right dateFrom" name="date_from" id="from" value="{{ old('date_from') }}">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="date_to">{{trans('date_to')}}</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right dateTo" name="date_to" id="to" value="{{ old('date_to') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 row" style="display:none" id="branch_banner">
                                        <div class="form-group col-md-4" id="vendor">
                                            <div class="form-group overflow-hidden">
                                                <label for="vendor_id">{{trans('vendor')}}</label>
                                                <select name="vendor_id" id="vendor_id"
                                                        class="form-control select2 w-100">
                                                    <option value="">{{ trans('select_vendor') }}</option>
                                                    @foreach($vendors as $vendor)
                                                        <option
                                                            value="{{ $vendor->id }}" {{ old("vendor_id") == $vendor->id ? "selected":null }}>{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="form-group overflow-hidden">
                                                <label for="branch_id">{{trans('select_branch')}}</label>
                                                <select name="branch_id" id="branch_id" class="form-control select2 w-100" id="branch_id">
                                                    <option value="">{{ trans('select_branch') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p style ="margin-top:-30px ">{{trans('image'). " * ". trans('notice_image_ratio_should_be_2to1') }} </p>
                                        <label class="custom-switch" class="text-center" style ="margin-right:90px ">
                                            <input type="file" onchange="readURL(this,'upload_img');" name="image" class="image"style="visibility: hidden">
                                            <img id="upload_img"  src="{{ asset('assets/img/add_img.jpg')}}" style ="width:100px;height:100px; border-radius:50px; margin-top:-10px ;margin-right:70px ;">
                                        </label>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" checked class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-12 row">
                                        <div class="form-group col-md-3">
                                            <button type="submit" href="#" class="btn  btn-outline-primary m-b-5  m-t-5"><i class="fa fa-save"></i> {{trans('save')}}</button>
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


@section('scripts')
    <script>

        if ($('#types').val() == '{{ BannerTypes::GLOBAL }}') {
            $('#branch_banner').hide();
            $('#branch_id').val(null);
            $("#branch_id").prop('required', false);
        }

        if ($('#types').val() == '{{ BannerTypes::BRANCH_BANNER }}') {
            $('#branch_banner').show();
            $("#branch_id").prop('required', true);
            var vendor = $('#vendor_id').val();
            if (vendor > 0) {
                gitVendorBranches(vendor);
            }
        }

        $('#types').on('change', function () {
            $('#branch_banner').hide();
            $("#branch_id").prop('required', false);
            $('#branch_id').val(null);
            if (this.value == '{{ BannerTypes::BRANCH_BANNER }}') {
                $('#branch_banner').show();
                $("#branch_id").prop('required', true);
            }

        });

        $('#vendor_id').on('change', function () {
            var vendor = this.value;
            gitVendorBranches(vendor);

        });

        function gitVendorBranches(vendor) {
            $.ajax({
                url: '{{ route("api.branches.index") }}',
                type: 'get',
                data: {_token: '{{ csrf_token() }}', 'vendor': vendor},

                success: function (data) {
                    var html = '<option value ="">{{ trans("select_branch") }}</option>';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html +=
                            '<option value ="' + data[i].id + '">' + data[i].name + '</option>';

                    }
                    $('#branch_id').html(html);
                },
                error: function () {
                    // alert("error");
                }
            });//end ajax
        }
    </script>
@endsection
