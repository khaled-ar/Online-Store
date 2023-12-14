<?php

use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportProductsController;


// Route::group([
//     'middleware' => ['auth', 'verified'],
//     'as' => 'dashboard.',
//     'prefix' => 'dashboard',
// ], function() {
//     Route::resource('/categories', CategoriesController::class);
//     Route::get('/', [AdminController::class, 'index'])->name('dashboard');
// });

Route::middleware(['auth', 'verified', 'auth.user'])
    ->as('dashboard.')
    ->prefix('dashboard')
    ->group(function() {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('categories/trash', [CategoriesController::class, 'trash'])
        ->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])
        ->name('categories.restore');
    Route::delete('categories/{category}/forc-delete', [CategoriesController::class, 'forceDelete'])
        ->name('categories.force-delete');

    Route::get('products/trash', [ProductsController::class, 'trash'])
        ->name('products.trash');
    Route::put('products/{product}/restore', [ProductsController::class, 'restore'])
        ->name('products.restore');
    Route::delete('products/{product}/forc-delete', [ProductsController::class, 'forceDelete'])
        ->name('products.force-delete');

    Route::get( 'products/import', [ ImportProductsController::class, 'create' ] )
    ->name( 'products.import' );
    Route::post( 'products/import', [ ImportProductsController::class, 'store' ] );

    Route::get('users/trash', [UsersController::class, 'trash'])
        ->name('users.trash');
    Route::put('users/{user}/restore', [UsersController::class, 'restore'])
        ->name('users.restore');
    Route::delete('users/{user}/forc-delete', [UsersController::class, 'forceDelete'])
        ->name('users.force-delete');

    Route::get('admins/make-admin/{admin}', [AdminsController::class, 'makeAdmin'])
        ->name('admins.make-admin');
    Route::get('admins/trash', [AdminsController::class, 'trash'])
        ->name('admins.trash');
    Route::put('admins/{admin}/restore', [AdminsController::class, 'restore'])
        ->name('admins.restore');
    Route::delete('admins/{admin}/forc-delete', [AdminsController::class, 'forceDelete'])
        ->name('admins.force-delete');

    Route::resource('/categories', CategoriesController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/orders', OrdersController::class);
    Route::resource('/roles', RolesController::class);
    Route::resource('/admins', AdminsController::class);
    Route::resource('/users', UsersController::class);

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
});

