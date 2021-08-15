<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="nav-link pl-1 pr-1 leading-none ">
                <img src="{{ asset( auth()->user()->image) }}" alt="user-img"
                     class="avatar-xl rounded-circle mb-1">
                <span class="pulse bg-success" aria-hidden="true"></span>
            </div>
            <div class="user-info">
                <h6 class=" mb-1 text-dark">{{auth()->user()->user_name}}</h6>
                <span class="text-muted app-sidebar__user-name text-sm">{{ auth()->user()->email }} </span>
            </div>
        </div>
    </div>
    <ul class="side-menu">
        <li>
            <a class="side-menu__item" href="{{ route('admin.home.index') }}">
                <i class="side-menu__icon fa fa-area-chart"></i>
                <span class="side-menu__label">{{ trans('dashboard') }}</span>
            </a>
        </li>
        @can("index", Vendor::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.vendors.index') }}">
                    <span><i class="side-menu__icon fa fa-building"></i>{{ trans('vendors') }}</span>
                </a>
            </li>
        @endcan
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i
                    class="side-menu__icon fa fa-shopping-basket"></i><span class="side-menu__label">{{ trans('catalogue') }}</span><i
                    class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">

                @can("index", Product::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.products.index') }}">
                            <span><i class="side-menu__icon fa fa-shopping-cart"></i>{{ trans('products') }}</span>
                        </a>
                    </li>
                @endcan

                @can("index", Order::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.orders.index') }}">
                            <span><i class="side-menu__icon fa fa fa-money"></i>{{ trans('orders') }}</span>
                        </a>
                    </li>
                @endcan
                @can("index", Payment::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.payments.index') }}">
                            <span><i class="side-menu__icon fa fa fa-money"></i>{{ trans('payments') }}</span>
                        </a>
                    </li>
                @endcan
                {{-- must get the model with full path resolve emmaguaty between our model ans category model in vendor --}}
                @can("index", \App\Models\Category::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.categories.index') }}">
                            <span><i class="side-menu__icon fa fa-tags"></i>{{ trans('categories') }}</span>
                        </a>
                    </li>
                @endcan

                @can("index", Activity::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.activities.index') }}">
                            <span><i class="side-menu__icon fa fa-sitemap"></i>{{ trans('activities') }}</span>
                        </a>
                    </li>
                @endcan

                @can("index", Unit::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.units.index') }}">
                            <span><i class="side-menu__icon fa fa-balance-scale"></i>{{ trans('units') }}</span>
                        </a>
                    </li>
                @endcan

{{--                <li>--}}
{{--                    <a class="slide-item" href="{{ route('admin.consumption') }}">--}}
{{--                        <span><i class="side-menu__icon fa fa-balance-scale"></i>{{ trans('consumption') }}</span>--}}
{{--                    </a>--}}
{{--                </li>--}}

            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="side-menu__icon fa fa-users"></i><span
                    class="side-menu__label">{{ trans('users') }}</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                @can("index", User::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.users.index') }}">
                            <span><i class="side-menu__icon fa fa-user"></i>{{ trans('users') }}</span>
                        </a>
                    </li>
                @endcan

                @can("index" , Group::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.groups.index') }}">
                            <span><i class="side-menu__icon fa fa-group"></i>{{ trans('groups') }}</span>
                        </a>
                    </li>
                @endcan
                @can("index", Permission::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.permissions.index') }}">
                            <span><i class="side-menu__icon fa fa-key"></i>{{ trans('permissions') }}</span>
                        </a>
                    </li>
                @endcan
                @can('index', Subscriber::class)
{{--                    <li>--}}
{{--                        <a class="slide-item" href="{{ route('admin.subscribers.index') }}">--}}
{{--                            <span><i class="side-menu__icon fa fa-sitemap"></i>{{ trans('subscribers') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                @endcan

            </ul>
        </li>
        @can("index", Location::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.locations.index') }}">
                    <span><i class="side-menu__icon fa fa-map-pin"></i>{{ trans('locations')."( ".trans('zones'). ")"  }}</span>
                </a>
            </li>
        @endcan
        @can("index", Branch::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.branches.index') }}">
                    <span><i class="side-menu__icon fa fa fa-building-o"></i>{{ trans('branches') }}</span>
                </a>
            </li>
        @endcan

        @can("index", Stock::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.stocks.index') }}">
                    <span><i class="side-menu__icon fa fa fa-building"></i>{{ trans('stocks') }}</span>
                </a>
            </li>
        @endcan
        @can("index", Transaction::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.transactions.index') }}">
                    <span><i class="side-menu__icon fa fa fa-exchange"></i>{{ trans('transactions') }}</span>
                </a>
            </li>
        @endcan
        @can("index", Segmentation::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.segmentations.index') }}">
                    <span><i class="side-menu__icon fa fa fa-group"></i>{{ trans('segmentations') }}</span>
                </a>
            </li>
        @endcan
        @can("index", Subscribe::class)
        <li>
            <a class="side-menu__item" href="{{ route('admin.subscribes.index') }}">
                <span><i class="side-menu__icon fa fa fa-group"></i>{{ trans('subscribes') }}</span>
            </a>
        </li>
        @endcan
        @can("index", Setting::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.settings.index') }}">
                    <span><i class="side-menu__icon fa fa-cogs"></i>{{ trans('settings') }}</span>
                </a>
            </li>
        @endcan
        @can("index", CancelReason::class)
        <li>
            <a class="side-menu__item" href="{{ route('admin.cancelReasons.index') }}">
                <span><i class="side-menu__icon fa fa fa-list"></i>{{ trans('cancel_reasons') }}</span>
            </a>
        </li>
        @endcan
        @can("index", Ticket::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.tickets.index') }}">
                    <span><i class="side-menu__icon fa ti ti-headphone-alt"></i>{{ trans('tickets') }}</span>
                </a>
            </li>
        @endcan
        @can("index", Vehicle::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.vehicles.index') }}">
                    <span><i class="side-menu__icon fa ti ti-truck"></i>{{ trans('vehicles') }}</span>
                </a>
            </li>
        @endcan
        @can("index", ShippingCompany::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.shippingCompanies.index') }}">
                    <span><i class="side-menu__icon fa fa fa-building-o"></i>{{ trans('shipping_companies') }}</span>
                </a>
            </li>
        @endcan

        @can("index", Banner::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.banners.index') }}">
                    <span><i class="side-menu__icon fa ti ti-signal"></i>{{ trans('banners') }}</span>
                </a>
            </li>
        @endcan

        @can("index", Company::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.companies.index') }}">
                    <span><i class="side-menu__icon fa fa-building"></i>{{ trans('companies') }}</span>
                </a>
            </li>
        @endcan

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-gift"></i>
                <span class="side-menu__label">{{trans('promotions')}}</span>
                <i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                @can("index", Voucher::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.vouchers.index') }}">
                            <span><i class="side-menu__icon fa ti ti-gift"></i>{{ trans('vouchers') }}</span>
                        </a>
                    </li>
                @endcan

                @can("index", Coupon::class)
                    <li>
                        <a class="slide-item" href="{{ route('admin.coupons.index') }}">
                            <span><i class="side-menu__icon fa fa-diamond"></i>{{ trans('coupons') }}</span>
                        </a>
                    </li>
                @endcan

                @can("index", Discount::class)
{{--                    <li>--}}
{{--                        <a class="slide-item" href="{{ route('admin.discounts.index') }}">--}}
{{--                            <span><i class="side-menu__icon fa fa-percent"></i>{{ trans('discounts') }}</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                @endcan
            </ul>
        </li>


        @can("index", Log::class)
            <li>
                <a class="side-menu__item" href="{{ route('admin.logs.index') }}">
                    <span><i class="side-menu__icon fa fa-pie-chart"></i>{{ trans('logs') }}</span>

                </a>
            </li>
        @endcan
        @if(auth()->user()->hasAccess("admin.shipments.index") || auth()->user()->hasAccess("admin.actual_shipments.index"))
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-ship"></i>
                <span class="side-menu__label">{{trans('shipments')}}</span>
                <i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                @can("index", Shipment::class)
                <li>
                    <a class="slide-item" href="{{ route('admin.shipments.index') }}">
                        <span><i class="side-menu__icon fa fa-truck"></i>{{ trans('shipments') }}</span>
                    </a>
                </li>
                @endcan
                @can("index", ActualShipment::class)
                <li>
                    <a class="slide-item" href="{{ route('admin.actual-shipments.index') }}">
                        <span><i class="side-menu__icon fa fa-truck"></i>{{ trans('actual_shipments') }}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
        @can('quantityAnalysis', Report::class)
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="side-menu__icon fa fa-file-excel-o"></i>
                <span class="side-menu__label">{{trans('reports')}}</span>
                <i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                @can('quantityAnalysis', Report::class)
                <li>
                    <a class="slide-item" href="{{ route('admin.reports.quantity') }}">
                        <span><i class="side-menu__icon fa fa-file-excel-o"></i>{{ trans('quantity_analysis') }}</span>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</aside>
