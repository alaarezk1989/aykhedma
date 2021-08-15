@extends('web.layout')

@section('content')
    <header>
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 img-slider" src="/assets/img/slider_img.jpg" alt="First slide">
                    <div class="carousel-caption">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <h1>خدمة التوصيل تحت الطلب في جميع أنحاء الجمهورية</h1>
                                    </div>
                                </div>
                            </div>
                            @if(session()->has('search_error'))
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-8 mx-auto">
                                            <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                                <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                                <div class="alert-body">
                                                    <button class="close" data-dismiss="alert">
                                                        <span>×</span>
                                                    </button>
                                                    {{ session('search_error') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <form action="{{ route('web.search') }}" method="GET" class="col-lg-8 mx-auto p-5">
                                <lookups></lookups>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-block btn-serch">تصفح المتاجر</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="nav-bottom">
                <p>احصل على أغراضك لتصلك حتى منزلك أينما كنت <a href="#">كيف <img src="/assets/img/Icons/arrow_left_red.png" alt=""></a></p>
            </div>
        </div>

    </header>

    <!-- Start Sec 1 -->
    <section class="sec1 text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <h1>خيارات عديدة من المنتجات و الاهتمامات</h1>
                    <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ</p>
                </div>
                <div class="col">
                    <div class="box-sec1">
                        <img src="/assets/img/Icons/stores.png" alt="">
                        <p>متاجر</p>
                    </div>
                </div>
                <div class="col">
                    <div class="box-sec1">
                        <img src="/assets/img/Icons/grocery.png" alt="">
                        <p>فواكه و خضروات</p>
                    </div>
                </div>
                <div class="col">
                    <div class="box-sec1">
                        <img src="/assets/img/Icons/bakery.png" alt="">
                        <p>مخبوزات</p>
                    </div>
                </div>
                <div class="col">
                    <div class="box-sec1">
                        <img src="/assets/img/Icons/restuarant.png" alt="">
                        <p>مطاعم</p>
                    </div>
                </div>
                <div class="col">
                    <div class="box-sec1">
                        <img src="/assets/img/Icons/meat.png" alt="">
                        <p>لحوم</p>
                    </div>
                </div>
                <div class="col">
                    <div class="box-sec1">
                        <img src="/assets/img/Icons/pharma.png" alt="">
                        <p>أدوية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Sec1 -->
    <!-- Start Sec2 -->

    <section class="sec2">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <h1 class="text-right">كن على اتصال اينما كنت </h1>
                        <p>حمل تطبيق <strong>أي خدمة</strong> مجانا لمنصات التشغيل المختلفة</p>
                        <div class="row">
                            <div class="col-12 mx-auto text-center">
                                <a class="mr-5" href="#">
                                    <img class="" src="/assets/img/Icons/from_appstore.png" alt="app">
                                </a>
                                <a class="mr-5" href="#">
                                    <img class="" src="/assets/img/Icons/from_playstore.png" alt="app">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end Sec3 -->

    <!-- Start Sec4 -->
    <section class="sec4">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>أهم المتاجر لدينا</h1>
                    <p>لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام</p>
                </div>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4"> <img src="/assets/img/images.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4">
                                    <img src="/assets/img/images.png">
                                </div>
                                <div class="col box-sec4"> <img src="/assets/img/images.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

    </section>
    <!-- end Sec4 -->
@stop
