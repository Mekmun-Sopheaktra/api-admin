<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Livewire\Categories\All as AllCategories;
use App\Livewire\ProductGallery\Add as AddGallery;
use App\Livewire\ProductGallery\All as AllGallery;
use App\Livewire\Products\Add as AddProduct;
use App\Livewire\Products\All as AllProducts;
use App\Livewire\Users\All as AllUsers;
use Illuminate\Support\Facades\Route;

//route home
Route::get('/', [WebAuthController::class, 'home'])->name('home');

//register route with controller
Route::get('register', [WebAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [WebAuthController::class, 'register']);
//register done
Route::get('register-done', function() {
    return view('auth.register-done');
})->name('register.done');
//register fail
Route::get('register-fail', function() {
    return view('auth.register-fail');
})->name('register.fail');

Route::get('/account/status', [WebAuthController::class, 'showStatus'])->middleware('auth')->name('verification-status');
//logout route
Route::post('logout', [WebAuthController::class, 'logout'])->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin',
])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('users', AllUsers::class)->name('admin.users');
    Route::get('categories', AllCategories::class)->name('admin.categories');
    Route::get('products', AllProducts::class)->name('admin.products');
    Route::get('products/create', AddProduct::class)->name('admin.products.add');
    Route::get('products/{product}/gallery', AllGallery::class)->name('admin.products.gallery');
    Route::get('products/{product}/gallery/create', AddGallery::class)->name('admin.products.gallery.create');
});

//Route::get('/mail', function() {
//    $code = "123456";
//
//    Mail::to(['mekmunsopheaktra@gmail.com'])->send(new VerifyUser($code));
//
//    return view('mail.verify-user', compact('code'));
//})->middleware('auth')->name('verification.notice');
//
//Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//    $request->fulfill();
//
//    return redirect('/home');
//})->middleware(['auth', 'signed'])->name('verification.verify');

Route::prefix('v1')->group(function () {
    Route::get('email/verify/{id}/{hash}', [WebAuthController::class, 'verify'])->name('web.verification.verify');
});
