<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\SitemapController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishlistController;
use App\Models\User;
use App\Notifications\OTPSms;
use Illuminate\Support\Facades\Route;
use Ghasedak\GhasedakApi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin-panel/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware(['permission:admin-panel']);

Route::prefix('admin-panel/management')->name('admin.')->group(function (){

    Route::resource('brands', BrandController::class)->middleware(['role:admin']);
    Route::resource('attributes', AttributeController::class)->middleware(['permission:create-product|edit-product']);
    Route::resource('categories', CategoryController::class)->middleware(['permission:create-product|edit-product']);
    Route::resource('tags', TagController::class)->middleware(['permission:create-product|edit-product']);
    Route::resource('products', ProductController::class)->middleware(['permission:create-product|edit-product']);
    Route::resource('banners', BannerController::class)->middleware(['role:admin']);
    Route::resource('comments', CommentController::class)->middleware(['permission:create-product|edit-product']);
    Route::resource('coupons', CouponController::class)->middleware(['permission:check-orders|check-transaction']);
    Route::resource('orders', OrderController::class)->middleware(['permission:check-orders|check-transaction']);
    Route::resource('transactions', TransactionController::class)->middleware(['permission:check-orders|check-transaction']);
    Route::resource('users', UserController::class)->middleware(['role:admin']);
    Route::resource('permissions', PermissionController::class)->middleware(['role:admin']);
    Route::resource('roles', RoleController::class)->middleware(['role:admin']);

    Route::get('/comments/{comment}/change-status', [CommentController::class, 'changeStatus'])->name('comment.change-status')->middleware(['permission:create-product|edit-product']);
    // Get Category Attributes With Api
    Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes'])->middleware(['permission:create-product|edit-product']);

    // Edit Product Image
    Route::get('/products/{product}/images-edit', [ProductImageController::class, 'edit'])->name('products.images.edit')->middleware(['permission:create-product|edit-product']);
    Route::delete('/products/{product}/images-destroy', [ProductImageController::class, 'destroy'])->name('products.images.destroy')->middleware(['permission:create-product|edit-product']);
    Route::put('/products/{product}/images-set-primary', [ProductImageController::class, 'setPrimary'])->name('products.images.set_primary')->middleware(['permission:create-product|edit-product']);
    Route::post('/products/{product}/images-add', [ProductImageController::class, 'add'])->name('products.images.add')->middleware(['permission:create-product|edit-product']);

    // Edit Product Image
    Route::get('/products/{product}/category-edit', [ProductController::class, 'editCategory'])->name('products.category.edit')->middleware(['permission:create-product|edit-product']);
    Route::put('/products/{product}/category-update', [ProductController::class, 'updateCategory'])->name('products.category.update')->middleware(['permission:create-product|edit-product']);

});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('home.categories.show');
Route::get('/products/{product:slug}', [HomeProductController::class, 'show'])->name('home.products.show');
Route::post('/comments/{product}', [HomeCommentController::class, 'store'])->name('home.comments.store');

Route::get('/add-to-wishlist/{product}', [WishlistController::class, 'add'])->name('home.wishlist.add');
Route::get('/remove-from-wishlist/{product}', [WishlistController::class, 'remove'])->name('home.wishlist.remove');

Route::get('/compare', [CompareController::class, 'index'])->name('home.compare.index');
Route::get('/add-to-compare/{product}', [CompareController::class, 'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}', [CompareController::class, 'remove'])->name('home.compare.remove');

Route::get('/cart', [CartController::class, 'index'])->name('home.cart.index');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('home.cart.add');
Route::get('/remove-from-cart/{rowId}', [CartController::class, 'remove'])->name('home.cart.remove');
Route::put('/cart', [CartController::class, 'update'])->name('home.cart.update');
Route::get('/clear-cart', [CartController::class, 'clear'])->name('home.cart.clear');
Route::post('/check-coupon', [CartController::class, 'checkCoupon'])->name('home.coupons.check')->middleware('auth');
Route::get('/checkout', [CartController::class, 'checkout'])->name('home.orders.checkout')->middleware('auth');

Route::post('/payment', [PaymentController::class, 'payment'])->name('home.payment')->middleware('auth');
Route::get('/payment-verify/{gatewayName}', [PaymentController::class, 'paymentVerify'])->name('home.payment_verify')->middleware('auth');

Route::any('/login', [AuthController::class, 'login'])->name('login');
Route::post('/check-otp', [AuthController::class, 'checkOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

    // For Email Login
//Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider'])->name('provider.login');
//Route::get('/login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

Route::prefix('profile')->name('home.')->group(function (){
    Route::get('/', [UserProfileController::class, 'index'])->name('users_profile.index');
    Route::get('/comments', [HomeCommentController::class, 'userProfileIndex'])->name('comments.users_profile.index');
    Route::get('/wishlist', [WishlistController::class, 'userProfileIndex'])->name('wishlist.users_profile.index');

    Route::get('/addresses', [AddressController::class, 'index'])->name('address.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('address.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('address.update');

    Route::get('/orders', [CartController::class, 'usersProfileIndex'])->name('orders.users_profile.index')->middleware('auth');
});

Route::get('/get-province-cities-list', [AddressController::class, 'getProvinceCitiesList']);

Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('home.about-us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('home.contact-us');
Route::post('/contact-us-form', [HomeController::class, 'contactUsForm'])->name('home.contact-us.form');

Route::get('/sitemap', [SitemapController::class, 'index'])->name('home.sitemap.index');

Route::get('/test', function (){
   auth()->logout();
   return redirect()->route('home.index');

//    \Cart::clear();
//    dd(\Cart::getContent());
//    dd(session('coupon.id'));
});
