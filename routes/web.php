<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('butik.route_shop-prefix'))->name('butik.')->namespace('Http\\Controllers\\Web\\')->group(function() {
    Route::get('/', 'ShopController@index')->name('shop');

    Route::get(config('butik.route_payment-receipt'), 'ExpressCheckoutController@receipt')->name('payment.receipt');

    Route::get(config('butik.route_express-checkout-delivery').'/{product}', 'ExpressCheckoutController@delivery')->name('checkout.express.delivery');
    Route::post(config('butik.route_express-checkout-delivery').'/{product}', 'ExpressCheckoutController@saveCustomerData')->name('checkout.express.delivery');
    Route::get(config('butik.route_express-checkout-payment'), 'ExpressCheckoutController@payment')->name('checkout.express.payment')->middleware('validateCheckoutCart');
    Route::get('payment/process', 'PaymentGatewayController@processPayment')->name('payment.process')->middleware('validateCheckoutCart');

    Route::get('{product}', 'ShopController@show')->name('shop.product');
});

// Webhook without butik prefix
Route::post('payment/webhook/mollie', 'Http\\Controllers\\Web\\PaymentGatewayController@webhook')->name('butik.payment.webhook.mollie');
