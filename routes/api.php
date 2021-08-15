<?php

use Illuminate\Http\Request;
//auth()->loginUsingId(1);
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->attribute('namespace', 'Api')->group(function () {
    Route::get('/locations', ['uses' => 'LocationsController@index', 'as' => 'api.locations.index']);
    Route::get('/activities', ['uses' => 'ActivitiesController@index', 'as' => 'api.activities.index']);
    Route::get('/settings', ['uses' => 'SettingsController@index', 'as' => 'api.settings.index']);
    Route::get('/addresses', ['uses' => 'AddressesController@index', 'as' => 'api.addresses.index']);
    Route::get('/search', ['uses' => 'SearchController@search', 'as' => 'api.search']);
    Route::get('/branches', ['uses' => 'BranchesController@index', 'as' => 'api.branches.index']);
    Route::get('/branchess', ['uses' => 'VendorsController@branches', 'as' => 'api.vendors.branches']);
    Route::get('/vendors', ['uses' => 'VendorsController@index', 'as' => 'api.vendors.index']);
    Route::get('/shipmentModelData', ['uses' => 'ShipmentsController@getModelData', 'as' => 'api.shipment.ModelData']);
    Route::get('/user/types', ['uses' => 'UsersController@types', 'as' => 'api.users.types']);
});

// Non-Logged in users API's
Route::prefix('v1')->attribute('namespace', 'Api')->group(function () {
    Route::get('/locations/{location}', ['uses' => 'LocationsController@show', 'as' => 'api.locations.show']);
    Route::get('/nearest', ['uses' => 'LocationsController@nearest', 'as' => 'api.locations.nearest']);
    Route::get('/categories', ['uses' => 'CategoriesController@index', 'as' => 'api.categories.index']);
    Route::get('/categories/{category}', ['uses' => 'CategoriesController@show', 'as' => 'api.categories.show']);
    Route::get('/products', ['uses' => 'ProductsController@index', 'as' => 'api.products.index']);
    Route::post('/register', ['uses' => 'AuthController@register', 'as' => 'api.auth.register']);
    Route::post('/login', ['uses' => 'AuthController@login', 'as' => 'api.auth.login']);
    Route::get('/banners', ['uses' => 'BannersController@index', 'as' => 'api.banners.index']);
    Route::post('/password/reset', 'AuthController@resetPassword');
    Route::get('/search/products', ['uses' => 'BranchesController@products', 'as' => 'api.search.products']);
    Route::get('/search/categories', ['uses' => 'SearchController@searchCategories', 'as' => 'api.search.categories']);
    Route::get('/products/{branchProduct}', ['uses' => 'ProductsController@info', 'as' => 'api.products.info']);
    Route::get('/vendors/{vendor}/reviews', ['uses' => 'VendorReviewsController@index', 'as' => 'api.vendor.reviews']);
    Route::get('/branches/{branch}/reviews', ['uses' => 'BranchReviewsController@index', 'as' => 'api.branch.reviews']);
    Route::get('/products/{product}/reviews', ['uses' => 'ProductReviewsController@index', 'as' => 'api.product.reviews']);
    Route::get('/account/balance', ['uses' => 'TransactionController@balance', 'as' => 'api.account.balance']);
    Route::get('/time-slots', ['uses' => 'ShipmentsController@timeSlots', 'as' => 'api.order.time.slot']);
});

// Only Logged in users API
Route::prefix('v1')->attribute('namespace', 'Api')->middleware('auth:api')->group(function () {
    Route::get('/user/addresses', ['uses' => 'AddressesController@index', 'as' => 'api.user.addresses.index']);
    Route::delete('/user/addresses/{address}', ['uses' => 'AddressesController@destroy', 'as' => 'api.addresses.destroy']);
    Route::post('/user/addresses', ['uses' => 'AddressesController@store', 'as' => 'api.addresses.store']);
    Route::post('/user/devices', ['uses' => 'UsersController@storeUserDevice', 'as' => 'api.user.devices.store']);
    Route::delete('/user/devices/{token}', ['uses' => 'UsersController@destroyUserDevice', 'as' => 'api.user.devices.destroy']);
    Route::get('/user/orders', ['uses' => 'OrdersController@index', 'as' => 'api.user.orders']);
    Route::delete('/orders/{order}', ['uses' => 'OrdersController@cancel', 'as' => 'api.order.cancel']);
    Route::get('/user/orders/{order}', ['uses' => 'OrdersController@show', 'as' => 'api.user.order']);
    Route::post('/user/orders', [ 'uses' => 'OrdersController@store', 'as' => 'api.orders.store']);
    Route::get('/user/tickets', ['uses' => 'TicketsController@index', 'as' => 'api.user.tickets']);
    Route::post('/user/tickets', ['uses' => 'TicketsController@store', 'as' => 'api.user.ticket.store']);
    Route::post('/favourites', ['uses' => 'FavoritedProductsController@toggle', 'as' => 'api.favorited.products.toggle']);
    Route::get('/favourites', ['uses' => 'FavoritedProductsController@index', 'as' => 'api.favorited.products']);
    Route::post('/user/profile', ['uses' => 'UsersController@updateProfile', 'as' => 'api.profile.update']);
    Route::post('/vendors/{vendor}/reviews', ['uses' => 'VendorReviewsController@store', 'as' => 'api.vendor.reviews.store']);
    Route::post('/branches/{branch}/reviews', ['uses' => 'BranchReviewsController@store', 'as' => 'api.branch.reviews.store']);
    Route::post('/products/{product}/reviews', ['uses' => 'ProductReviewsController@store', 'as' => 'api.product.reviews.store']);
    Route::get('/user/resend/phoneverified', ['uses' => 'UsersController@resendPhoneVerified', 'as' => 'api.user.resend.phoneverified']);
    Route::post('/user/verify/phone', ['uses' => 'UsersController@verifyPhone', 'as' => 'api.user.verify']);
    Route::post('/payments/create', [ 'uses' => 'PaymentsController@store', 'as' => 'api.payments.store']);
    Route::post('/logout', ['uses' => 'AuthController@logout', 'as' => 'api.auth.logout']);
    Route::PUT('/user/update', 'AuthController@update');
    Route::PUT('/user/password/update', ['uses' => 'AuthController@passwordUpdate', 'as' => 'api.driver.passwordUpdate']);
    Route::get('/validate/code', ['uses' => 'OrdersController@validatePromotionCode', 'as' => 'api.order.validate.code']);
    Route::get('/validate/order/amount', ['uses' => 'OrdersController@validateMinimumOrderAmount', 'as' => 'api.order.validate.amount']);
    Route::get('/user/points', ['uses' => 'UsersController@points', 'as' => 'api.user.points']);
    Route::post('/user/picture', ['uses' => 'UsersController@uploadProfile', 'as' => 'api.user.profile.picture']);
});
Route::prefix('v1')->attribute('namespace', 'Api\Driver')->middleware('auth:api')->group(function () {
    Route::get('/user/profile', ['uses' => 'DriverController@profile', 'as' => 'api.user.profile']);
    Route::get('/driver/orders', ['uses' => 'OrdersController@driverOrders', 'as' => 'api.driver.driver.orders']);
    Route::get('/contributor/orders', ['uses' => 'OrdersController@contributorOrders', 'as' => 'api.contributor.orders']);
    Route::get('/order/{order}/products', ['uses' => 'OrdersController@products', 'as' => 'api.driver.order.products']);
    Route::get('/order/statuses', ['uses' => 'OrdersController@statuses', 'as' => 'api.order.statuses']);
    Route::get('/vendor/branches', ['uses' => 'BranchesController@index', 'as' => 'api.branches.vendor.branches']);
    Route::POST('/order/{order}/confirm', ['uses' => 'OrdersController@confirm', 'as' => 'api.driver.confirm']);
    Route::POST('/order/{order}/accept', ['uses' => 'OrdersController@accept', 'as' => 'api.driver.accept']);
    Route::POST('/order/{order}/cancel', ['uses' => 'OrdersController@cancel', 'as' => 'api.driver.cancel']);
    Route::get('/vendor/drivers', ['uses' => 'DriverController@drivers', 'as' => 'api.vendor.drivers']);
    Route::POST('/driver/assign', ['uses' => 'DriverController@assignDriver', 'as' => 'api.driver.assign']);
    Route::POST('/driver/available', ['uses' => 'DriverController@available', 'as' => 'api.driver.available']);
    Route::POST('/driver/notification', ['uses' => 'DriverController@notification', 'as' => 'api.driver.notification']);
    Route::get('/order/cancel-list', ['uses' => 'OrdersController@cancelReasonsList', 'as' => 'api.orders.cancelReasonsList']);
    Route::POST('/contact', ['uses' => 'TicketController@store', 'as' => 'api.driver.contact']);
    Route::POST('/noti', ['uses' => 'DriverController@noti', 'as' => 'api.driver.noti']);
});
