@extends('web.layout')

@section('content')
<section class="sec5">
    <img class="img-responsive" src="/assets/img/store_img.jpg">
    <div class="sec5-info">
        <img class="img-sec5" src="/assets/img/22.jpg" alt="">
        <div class="dropdown">
            <a style="cursor: pointer" class="dropdown-toggle" data-toggle="dropdown">
                {{ $currentBranch->name }}
                <span class="caret"></span>
            </a>

            <div style="text-align: right" class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach($branches as $branch)
                    <a class="dropdown-item {{ $currentBranch->id == $branch->id ? 'active': '' }}" href="{{ route('web.search', array_merge(request()->all(['activity', 'zone']), ['branch' => $branch->id])) }}">{{ $branch->name }}</a>
                @endforeach
            </div>
        </div>
        <span>القاهرة</span>
        <p>للمهتمين قمنا بوضع نص لوريم إبسوم القياسي والمُستخدم</p>
    </div>
</section>
<br>

<section class="tabs">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <a class="tab1 active1" href="store2.html">
                    <img src="/assets/img/Icons/store_home_white.png">
                    <span class="text-center">الكل</span>
                </a>
            </div>
            <div class="col-lg-3">
                <a class="tab2" href="store-detils.html">
                    <img src="/assets/img/Icons/store_info_blue.png">
                    <span>بيانات</span>
                </a>
            </div>
            <div class="col-lg-3">
                <a class="tab3" href="store-rate.html">
                    <img src="/assets/img/Icons/review_yallow.png">
                    <span>تقييمات</span>
                </a>
            </div>
            <div class="col-lg-3">
                <a class="tab4" href="strore-favorte.html">
                    <img src="/assets/img/Icons/favorite_red.png">
                    <span>المفضلة</span>
                </a>
            </div>

        </div>
    </div>
</section>

<section class="sec6">
    <div class="container">
        <div class="row">
            <div div="" class="col-lg-3">
                <form class="filter2">
                    <div class="row">
                        <div class="col-12">
                            <h3>
                                <div class="col-12">
                                </div>الاقسام
                            </h3>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="" checked="">
                                <span>الكل</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="">
                                <span>خبز و برجر</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="">
                                <span>مشروبات</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="">
                                <span>سلطات و مقبلات</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="">
                                <span>ركن الافطار</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="">
                                <span>مشويات</span>
                            </label>
                        </div>
                        <div class="col-12">
                            <label>
                                <input type="checkbox" name="" id="">
                                <span>التحلية</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-9">
                <div class="row">
                    @foreach($currentBranch->products as $product)
                        <div class="col-lg-4">
                            <div class="box-sec6">
                                <a href="/product/{{$product->id}}">
                                    <img class="img-info" src="{{ $product->images->first()->image }}">
                                </a>
                                <div class="box-overlay">
                                    <div class="row">
                                        <div class="col-8">
                                            <h2>{{ $product->name }}</h2>
                                            <span> {{ $product->category->name }}</span>
                                        </div>
                                        <div class="col-4">
                                            <h3>{{ $product->pivot->price }}</h3>
                                            <small>LE</small>
                                        </div>
                                        <div class="col-8 mx-auto">
                                            <div class="span-info">
                                                <img src="/assets/img/Icons/add_to_cart_green.png">
                                            </div>
                                            <div class="span-info">
                                                <img src="/assets/img/Icons/favorite_red.png">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
@stop
