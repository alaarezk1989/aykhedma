@extends('admin.layout')

@section('content')
    <div class="app-content">
        <section class="section">

            <!--page-header open-->
            <div class="page-header">
                <h4 class="page-title">{{trans('subscribers')}}</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home.index') }}" class="text-light-color">{{trans('home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.subscribers.index') }}" class="text-light-color">{{trans('subscribers')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('update_subscriber')}} #{{ $subscriber->id }}</li>
                </ol>
            </div>
            <!--page-header closed-->

            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{trans('update_subscriber')}}</h4>
                            </div>
                            <div class="card-body">
                                @include('admin.errors')
                                <form action="{{ route('admin.subscribers.update', ['subscriber' => $subscriber]) }}" method="post" enctype="multipart/form-data">
                                    @method("PUT")
                                    @csrf

                                    <div class="form-group col-md-4">
                                        <label for="name">{{trans('email')}} *</label>
                                        <input type="text" class="form-control" name="email" value="{{ $subscriber->email }}" >
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="custom-switch">
                                            <input type="checkbox" name="active" value="1" {{ $subscriber->active ? 'checked' : '' }} class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{trans('active')}}</span>
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
@stop

<script type="text/javascript">

    /****** to preview uploaded image ******/
function readURL(input, img_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var image_id=$('#' + img_id);
        reader.onload = function (e) {
            image_id.attr('src', e.target.result);

        };
        image_id.css("width", "260px");
        image_id.css("height", "261px");
        reader.readAsDataURL(input.files[0]);
    }
}
/****************************************/
</script>
