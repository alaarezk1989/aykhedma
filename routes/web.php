<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the 'web' middleware group. Now create something great!
  |
 */


Route::prefix('{lang?}')->attribute('namespace', 'Web')->group(function () {
    Route::get('/', function () {
        return redirect(route('web.auth.login'));
    });
    Route::post('/attempt', ['uses' => 'AuthController@attempt', 'as' => 'web.auth.attempt']);
    Route::get('/logout', ['uses' => 'AuthController@logout', 'as' => 'web.auth.logout']);
    Route::get('/login', ['uses' => 'AuthController@login', 'as' => 'web.auth.login']);
    Route::get('/register', ['uses' => 'AuthController@register', 'as' => 'web.auth.register']);
    Route::post('/register', ['uses' => 'AuthController@registerAction', 'as' => 'web.auth.register']);
    Route::get('/password/reset', ['uses' => 'AuthController@reset', 'as' => 'password.reset']);
    Route::post('/password/reset', ['uses' => 'AuthController@sendReset', 'as' => 'web.auth.reset.send']);
    Route::post('/password/reset/confirm', ['uses' => 'AuthController@resetPassword', 'as' => 'web.auth.reset.confirm']);
    Route::post('/subscribe', ['uses' => 'SubscribersController@subscribe', 'as' => 'web.subscribe']);
    Route::get('/search', ['uses' => 'SearchController@search', 'as' => 'web.search']);
});

Route::prefix('{lang?}')->attribute('namespace', 'Web')->middleware('auth:web')->group(function () {
    Route::get('/user/profile', ['uses' => 'UserController@edit', 'as' => 'profile.edit']);
    Route::PUT('/user/profile', ['uses' => 'UserController@update', 'as' => 'profile.update']);
    Route::get('/user/password', ['uses' => 'UserController@editPassword', 'as' => 'password.edit']);
    Route::PUT('/user/password', ['uses' => 'UserController@updatePassword', 'as' => 'password.update']);
    Route::get('/user/tickets', ['uses' => 'TicketsController@myTickets', 'as' => 'web.user.tickets']);
});

Route::prefix('{lang?}/admin')->attribute('namespace', 'Admin')->middleware('admin:web')->group(function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'admin.home.index']);

    Route::prefix('order/{order}')->group(function () {
        Route::resource('products', 'OrderProductsController', ['as' => "admin.order"])
            ->parameter('products', 'orderProduct');
    });
    Route::get('/orders/export', ['uses' => 'OrdersController@export', 'as' => 'admin.orders.export']);
    Route::resource('orders', 'OrdersController', ['as' => 'admin']);
    Route::get('/branches/export', ['uses' => 'BranchesController@export', 'as' => 'admin.branches.export']);
    Route::resource('branches', 'BranchesController', ['as' => 'admin']);
    Route::get('/products/export', ['uses' => 'ProductController@export', 'as' => 'admin.products.export']);
    Route::resource('products', 'ProductController', ['as' => 'admin']);
    Route::delete("product/{product}/image/{productImage}", "ProductController@deleteImage")->name("admin.product.image.destroy");
    Route::resource('units', 'UnitsController', ['as' => 'admin']);
    Route::resource('segmentations', 'SegmentationsController', ['as' => 'admin']);
    Route::get('/users/export', ['uses' => 'UserController@export', 'as' => 'admin.users.export']);
    Route::resource('users', 'UserController', ['as' => 'admin']);
    Route::resource('revenues', 'RevenueController', ['as' => 'admin']);
    Route::prefix('/user/{user}')->group(function () {
        Route::resource('addresses', 'UserAddressesController', ['as' => "admin.user"]);
    });

    Route::prefix('/user/{user}')->group(function () {
        Route::resource('devices', 'UserDevicesController', ['as' => "admin.user"])
            ->parameter('devices', 'userDevice');
    });

    Route::resource('locations', 'LocationsController', ['as' => 'admin']);
    Route::resource('activities', 'ActivitiesController', ['as' => 'admin']);
    Route::resource('shippingCompanies', 'ShippingCompaniesController', ['as' => 'admin']);
    Route::resource('subscribers', 'SubscribersController', ['as' => 'admin']);
    Route::get('/tickets/export', ['uses' => 'TicketsController@export', 'as' => 'admin.tickets.export']);
    Route::resource('tickets', 'TicketsController', ['as' => 'admin']);

    Route::get('/ticket/{ticket}/details', ['uses' => 'TicketsController@details', 'as' => 'admin.ticket.details']);
    Route::post('/ticket/{ticket}/reply', ['uses' => 'TicketsController@reply', 'as' => 'admin.ticket.reply']);
    Route::resource('categories', 'CategoriesController', ['as' => 'admin']);
    Route::resource('vehicles', 'VehiclesController', ['as' => 'admin']);

    Route::post('/branch/{newBranch}/copy', ['uses' => 'BranchProductsController@copy', 'as' => 'admin.branch.products.copy']);
    Route::prefix("/branch/{branch}")->group(function () {
        Route::resource("products", "BranchProductsController", ['as' => "admin.branch"])
            ->parameter('products', 'branchProduct');
    });


    Route::prefix('/branch/{branch}')->group(function () {
        Route::resource('zones', 'BranchZonesController', ['as' => "admin.branch"])
            ->parameter('zones', 'branchZone')
            ->except(['show']);
    });

    Route::post('/reviews/{review}/publish', ['uses' => 'ProductReviewsController@publish', 'as' => 'admin.product.reviews.publish']);
    Route::prefix("/product/{product}")->group(function () {
        Route::resource("reviews", "ProductReviewsController", ['as' => "admin.product"]);
    });

    Route::resource('/groups', 'GroupController', ['as' => 'admin']);
    Route::resource('/permissions', 'PermissionController', ['as' => 'admin']);

    Route::post('/reviews/{review}/publish', ['uses' => 'VendorReviewsController@publish', 'as' => 'admin.vendor.reviews.publish']);
    Route::prefix("/vendor/{vendor}")->group(function () {
        Route::resource("reviews", "VendorReviewsController", ['as' => "admin.vendor"]);
    });

    Route::prefix("/users/{user}")->group(function () {
        Route::resource("groups", "UserGroupsController", ['as' => "admin.users"]);
    });

    Route::resource('/groups', 'GroupController', ['as' => 'admin'])->parameter('group', 'group');
    Route::resource('/permissions', 'PermissionController', ['as' => 'admin']);

    Route::prefix('/group/{group}')->group(function () {
        Route::resource('permissions', 'GroupPermissionController', ['as' => "admin.group"])
            ->parameter('permissions', 'groupPermission');
    });
    Route::get('/vendors/export', ['uses' => 'VendorsController@export', 'as' => 'admin.vendors.export']);
    Route::resource('vendors', 'VendorsController', ['as' => 'admin']);
    Route::get('/stocks/export', ['uses' => 'StocksController@export', 'as' => 'admin.stocks.export']);
    Route::resource('stocks', 'StocksController', ['as' => 'admin']);
    Route::get("/sendSMS", 'TestSMSController@sendSMS');
    Route::get("/test-email/{order}", 'TestSMSController@testMailTemplate');
    Route::get('/route', ['uses' => 'PaymentController@route', 'as' => 'web.payment.route']);
    Route::get("/checkout", ['uses' => 'CheckoutOrderController@checkout', 'as' => 'admin.order.checkout']);
    Route::get("/payment", ['uses' => 'CheckoutOrderController@processRequest', 'as' => 'admin.payment.process']);

    Route::get('/order/{order}/confirm', ['uses' => 'OrdersController@confirm', 'as' => 'admin.order.confirm']);
    Route::get('/order/{order}/deliver', ['uses' => 'OrdersController@deliver', 'as' => 'admin.order.deliver']);

    Route::prefix("/user/{user}")->group(function () {
        Route::resource("points", "UserPointsController", ['as' => "admin.user"]);
    });

    Route::resource('settings', 'SettingsController', ['as' => 'admin'])->only([
        "index", "edit", "update"
    ]);
    Route::resource('banners', 'BannersController', ['as' => 'admin']);
    Route::get('/logs', ['uses' => 'LogsController@index', 'as' => 'admin.logs.index']);
    Route::get('/coupons/export', ['uses' => 'CouponsController@export', 'as' => 'admin.coupons.export']);
    Route::resource('/coupons', 'CouponsController', ['as' => 'admin']);
    Route::get('/vouchers/{voucher}/list', ['uses' => 'VouchersController@list', 'as' => 'admin.vouchers.list']);
    Route::get('/vouchers/export', ['uses' => 'VouchersController@export', 'as' => 'admin.vouchers.export']);
    Route::get('/vouchers/{voucher}/list/export', ['uses' => 'VouchersController@exportList', 'as' => 'admin.vouchers.list.export']);
    Route::resource('vouchers', 'VouchersController', ['as' => 'admin']);
    Route::get('companies/{company}/users', ['uses' => 'CompanyController@getUsers', 'as' => 'admin.companies.users']);
    Route::resource('companies', 'CompanyController', ['as' => 'admin']);
    Route::resource('discounts', 'DiscountController', ['as' => 'admin']);
    Route::get('/transactions/export', ['uses' => 'TransactionsController@export', 'as' => 'admin.transactions.export']);
    Route::resource('transactions', 'TransactionsController', ['as' => 'admin']);
    Route::get('/shipments/export', ['uses' => 'ShipmentsController@export', 'as' => 'admin.shipments.export']);
    Route::resource('shipments', 'ShipmentsController', ['as' => 'admin']);
    Route::get('/consumption', ['uses' => 'OrderProductsController@consumption', 'as' => 'admin.consumption']);
    Route::get('/consumption/export', ['uses' => 'OrderProductsController@export', 'as' => 'admin.consumption.export']);
    Route::get('/payments/export', ['uses' => 'PaymentsController@export', 'as' => 'admin.payments.export']);
    Route::resource('payments', 'PaymentsController', ['as' => 'admin']);
    Route::get('/create/actual/shipments', ['uses' => 'ActualShipmentController@createActualShipments', 'as' => 'admin.create.actual.shipments']);
    Route::get('/actual-shipments/export', ['uses' => 'ActualShipmentController@export', 'as' => 'admin.actual.shipments.export']);
    Route::resource('actual-shipments', 'ActualShipmentController', ['as' => 'admin']);
    Route::resource('cancelReasons', 'CancelReasonController', ['as' => 'admin']);
    Route::resource('subscribes', 'SubscribeController', ['as' => 'admin']);
    Route::post('/settle', ['uses' => 'SettleController@store', 'as' => 'admin.settle.store']);
    Route::get('/settle', ['uses' => 'SettleController@create', 'as' => 'admin.settle.create']);
    Route::get('/reports/quantity-analysis', ['uses' => 'ReportsController@quantityAnalysisReport', 'as' => 'admin.reports.quantity']);
    Route::get('/reports/quantity/export', ['uses' => 'ReportsController@exportQuantity', 'as' => 'admin.reports.quantity.export']);
});

Route::prefix('{lang?}/vendor')->attribute('namespace', 'Vendor')->middleware('vendor:web')->group(function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'vendor.home.index']);
    Route::resource('branches', 'BranchesController', ['as' => 'vendor']);
    Route::prefix("/branch/{branch}")->group(function () {
        Route::resource("products", "BranchProductsController", ['as' => "vendor.branch"])
            ->parameter('products', 'branchProduct');
    });
    Route::prefix("/branch/{branch}")->group(function () {
        Route::resource("zones", "BranchZonesController", ['as' => "vendor.branch"])
            ->parameter('zones', 'branchZone');
    });

    Route::resource('staff', 'UserController', ['as' => 'vendor'])->parameters(["staff" => "user"]);

    Route::get('/order/{order}/confirm', ['uses' => 'OrderController@confirm', 'as' => 'vendor.order.confirm']);

    Route::resource('orders', 'OrderController', ['as' => 'vendor']);
    Route::prefix("/order/{order}")->group(function () {
        Route::resource("products", "OrderProductsController", ['as' => "vendor.order"])
            ->parameter('products', 'orderProduct');
    });
    Route::prefix("/users/{user}")->group(function () {
        Route::resource("groups", "UserGroupsController", ['as' => "vendor.users"]);
    });
});


// Route::prefix('{lang?}/driver')->attribute('namespace', 'Driver')->middleware('driver:web')->group(function () {
//    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'driver.home.index']);

// });
