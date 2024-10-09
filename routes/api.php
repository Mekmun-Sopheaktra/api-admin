<?php

use App\Http\Controllers\api\v1\AuthController as AuthController;
use App\Http\Controllers\admin\AuthController as AdminAuthController;
use App\Http\Controllers\api\v1\BasketController;
use App\Http\Controllers\api\v1\CommentController;
use App\Http\Controllers\api\v1\HomeController;
use App\Http\Controllers\api\v1\LikeController;
use App\Http\Controllers\api\v1\NotificationController;
use App\Http\Controllers\api\v1\OrderController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'Login'])->name('api.login');
    Route::post('register', [AuthController::class, 'Register'])->name('api.register');

    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

//user routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/permission', [AuthController::class, 'Permission']);
    Route::get('profile', [ProfileController::class, 'index'])->name('api.profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('api.update.profile');
    Route::get('home', [HomeController::class, 'index'])->name('api.home');

    Route::prefix('search')->group(function () {
        Route::get('filter', [HomeController::class, 'filter'])->name('api.filter.data');
        Route::get('', [HomeController::class, 'search'])->name('api.search.data');
    });

    Route::get('product/wishlist', [ProductController::class, 'wishlist'])->name('api.product.wishlist');
    Route::resource('product', ProductController::class)->except(['store', 'update', 'delete', 'edit']);
    Route::get('product/{product}/like', [LikeController::class, 'likeProduct'])->name('api.product.like');

    Route::get('comment/{product}', [CommentController::class, 'index'])->name('api.comment');
    Route::post('comment', [CommentController::class, 'store'])->name('api.comment.store');

    Route::prefix('cart')->group(function () {
        Route::get('', [BasketController::class, 'index'])->name('api.basket');
        Route::post('add', [BasketController::class, 'add'])->name('api.basket.add');
        Route::post('delete', [BasketController::class, 'delete'])->name('api.basket.delete');
        Route::post('buy', [BasketController::class, 'buy'])->name('api.basket.buy');
    });

    Route::prefix('orders')->group(function () {
        Route::get('', [OrderController::class, 'index']);
    });

    Route::get('address', [ProfileController::class, 'address'])->name('api.address');
    Route::post('address', [ProfileController::class, 'store_address'])->name('api.address.store');

    Route::get('notifications', [NotificationController::class, 'index'])->name('api.notifications');
    Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('api.notifications.unread');
});


//admin routes

Route::post('admin/login', [AdminAuthController::class, 'Login'])->middleware('api.admin')->name('api.admin.login');
Route::post('admin/register', [AdminAuthController::class, 'Register'])->middleware('api.admin')->name('api.admin.register');

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('api.admin.profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('api.admin.update.profile');
    Route::get('home', [HomeController::class, 'index'])->name('api.admin.home');

    Route::prefix('search')->group(function () {
        Route::get('filter', [HomeController::class, 'filter'])->name('api.admin.filter.data');
        Route::get('', [HomeController::class, 'search'])->name('api.admin.search.data');
    });

    Route::get('product/wishlist', [ProductController::class, 'wishlist'])->name('api.admin.product.wishlist');
    Route::resource('product', ProductController::class)
        ->except(['store', 'update', 'destroy', 'edit'])
        ->names([
            'index' => 'product.admin.index',
            'show' => 'product.admin.show',
            'create' => 'product.admin.create'
        ]);
    Route::get('product/{product}/like', [LikeController::class, 'likeProduct'])->name('api.admin.product.like');

    Route::get('comment/{product}', [CommentController::class, 'index'])->name('api.admin.comment');
    Route::post('comment', [CommentController::class, 'store'])->name('api.admin.comment.store');

    Route::prefix('cart')->group(function () {
        Route::get('', [BasketController::class, 'index'])->name('api.admin.basket');
        Route::post('add', [BasketController::class, 'add'])->name('api.admin.basket.add');
        Route::post('delete', [BasketController::class, 'delete'])->name('api.admin.basket.delete');
        Route::post('buy', [BasketController::class, 'buy'])->name('api.admin.basket.buy');
    });

    Route::prefix('orders')->group(function () {
        Route::get('', [OrderController::class, 'index']);
    });

    Route::get('address', [ProfileController::class, 'address'])->name('api.admin.address');
    Route::post('address', [ProfileController::class, 'store_address'])->name('api.admin.address.store');

    Route::get('notifications', [NotificationController::class, 'index'])->name('api.admin.notifications');
    Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('api.admin.notifications.unread');
});
