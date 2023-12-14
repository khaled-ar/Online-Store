<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrenceyConverterController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\StripeWebhooksController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get( '/', [ HomeController::class, 'index' ] )->name( 'home' );

Route::get( '/products', [ ProductsController::class, 'index' ] )
->name( 'products.index' );
Route::get( '/products/{product:slug}', [ ProductsController::class, 'show' ] )
->name( 'products.show' );

Route::delete( 'cart/{product_id}', [ CartController::class, 'destroy' ] );

Route::get( 'checkout', [ CheckoutController::class, 'create' ] )->name( 'checkout' );

Route::post( 'checkout', [ CheckoutController::class, 'store' ] )
->name( 'checkout.store' );

Route::post( 'currency', [ CurrenceyConverterController::class, 'store' ] )
->name( 'currency' );

Route::resource( 'cart', CartController::class );

Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add');
Route::delete('wishlist/{product_id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

Route::get('auth/{provider}/redirect', function ($provider) {
    return Socialite::driver($provider)->redirect();
})->name('auth.socialite.redirect');

Route::get('auth/{provider}/callback', function ($provider) {

    try{
        $provider_user = Socialite::driver($provider)->user();

        $user = User::where([
            'provider' => $provider,
            'provider_id' => $provider_user->id,
        ])->first();

        if(!$user) {
            $user = User::create([
                'name' => $provider_user->name,
                'email' => $provider_user->email,
                'email_verified_at' => now(),
                'provider_token' => $provider_user->token,
                'provider' => $provider,
                'provider_id' => $provider_user->id,
                'password' => Hash::make(Str::random(8)),
            ]);
        }

    } catch(Throwable $e) {
        return redirect()->route('login')->withErrors([
            'message' => $e->getMessage(),
        ]);
    }

    Auth::login($user);

    return redirect()->route('home');

})->name('auth.socialite.callback');

Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->name('orders.payments.create');
Route::post('orders/{order}/stripe/payment-intet', [PaymentsController::class, 'createStripePaymentIntet'])
->name('stripe.paymentIntet.create');
Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');
Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle']);

Route::get('/orders/{order}', [OrdersController::class, 'show'])
    ->name('orders.show');

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';

