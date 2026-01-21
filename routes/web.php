<?php

use App\Http\Controllers\Admin\ProductSimilarController;
use App\Http\Controllers\AgeVerificationController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GoDirectWebhookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/age-restricted', [AgeVerificationController::class, 'index'])->name('ageRestriction');
Route::post('/age-verification', [AgeVerificationController::class, 'store']);
Route::post('webhook/godirect-order-status', [GoDirectWebhookController::class, 'handle']);
Route::group(['middleware' => ['AgeRestriction']], function () {
    Auth::routes();
    Route::prefix('forgot-password')->middleware('guest')->group(function () {
        Route::get('/', [PasswordController::class, 'forgotPasswordForm'])->name('forgotPasswordForm');
        Route::post('/', [PasswordController::class, 'forgotPassword'])->name('forgotPassword');
    });
    Route::prefix('reset-password')->group(function () {
        Route::post('/', [PasswordController::class, 'resetPassword'])->middleware('guest')->name('resetPassword');
        Route::get('/{token}', [PasswordController::class, 'resetPasswordForm'])->middleware('guest')->name('resetPasswordForm');
    });

    Route::prefix('/')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('about-us', [HomeController::class, 'about'])->name('about');
        Route::get('faq', [HomeController::class, 'faqs'])->name('faq');
        Route::get('shipping-delivery', [HomeController::class, 'shippingDelivery'])->name('shippingDelivery');
        Route::get('returns', [HomeController::class, 'returns'])->name('returns');
        Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');
        Route::get('terms-condition', [HomeController::class, 'termsCondition'])->name('termsCondition');
        Route::get('contact-us', [HomeController::class, 'contact'])->name('contact');
        Route::post('contactSave', [HomeController::class, 'contactSave']);
        Route::post('newsletterSubscriptionSave', [HomeController::class, 'newsletterSubscriptionSave']);
        Route::get('press-release', [HomeController::class, 'pressRelease'])->name('pressRelease');
        Route::get('store-locator', [StoreController::class, 'index'])->name('stores');
        Route::post('storeCities', [StoreController::class, 'storeCities'])->name('storeCities');
        Route::post('storeSearch', [StoreController::class, 'storeSearch'])->name('storeSearch');
        Route::get('storeLocations', [StoreController::class, 'storeLocations'])->name('storeLocations');
        Route::post('productFilter', [ProductController::class, 'productFilter']);
        Route::post('productReviewSave', [ProductController::class, 'productReviewSave']);
        Route::get('my-orders', [UserController::class, 'orders'])->name('orders');
        Route::get('my-order-details/{id}', [UserController::class, 'orderDetails'])->name('orderDetails');
        Route::post('orderReturnForm', [UserController::class, 'orderReturnForm'])->name('orderReturnForm');
        Route::post('orderReturnConfirm', [UserController::class, 'orderReturnConfirm'])->name('orderReturnConfirm');
        Route::post('getStates', [HomeController::class, 'getStates'])->name('getStates');
        Route::post('age-verification-webhook', [CheckoutController::class, 'ageVerificationWebhook'])->name('ageVerificationWebhook');
        Route::post('shippingMethod', [CheckoutController::class, 'shippingMethod'])->name('shippingMethod');
        Route::get('order-placed', [PaymentController::class, 'orderPlaced'])->name('orderPlaced');
        Route::get('order-cancelled', [PaymentController::class, 'orderCancelled'])->name('orderCancelled');
        Route::get('my-wishlist', [UserController::class, 'wishlist'])->name('wishlist');
        Route::get('reloadWishlist', [UserController::class, 'reloadWishlist'])->name('reloadWishlist');
        Route::post('deleteWishlist', [UserController::class, 'deleteWishlist']);
        Route::post('itemWishlist', [ProductController::class, 'itemWishlist']);
        Route::post('searchSuggestions', [ProductController::class, 'searchSuggestions']);
        Route::get('search/{searchKey}', [ProductController::class, 'searchResults']);
    });

    // Blogs
    Route::prefix('blogs')->group(function () {
        Route::get('/', [BlogController::class, 'blogs'])->name('blogs');
        Route::get('/{slug}', [BlogController::class, 'blogDetails'])->name('blogDetails');
        Route::view('/1', 'public.blogs.blog1')->name('blog1');
        Route::view('/2', 'public.blogs.blog2')->name('blog2');
        Route::view('/3', 'public.blogs.blog3')->name('blog3');
    });

    // User Profile
    Route::prefix('my-profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::post('/edit', [UserController::class, 'profileUpdate'])->name('profileUpdate');
        Route::post('/change-password', [UserController::class, 'passwordUpdate'])->name('passwordUpdate');
    });

    // My Address
    Route::prefix('my-address')->group(function () {
        Route::get('/', [UserController::class, 'addresses'])->name('addresses');
        Route::get('/create', [UserController::class, 'addressCreate']);
        Route::post('/store', [UserController::class, 'addressStore']);
        Route::post('/edit', [UserController::class, 'addressEdit']);
        Route::post('/update', [UserController::class, 'addressUpdate']);
        Route::post('/preferred', [UserController::class, 'addressPreferred']);
        Route::post('/delete', [UserController::class, 'deleteAddress']);
        Route::get('/reload', [UserController::class, 'reloadAddress']);
        Route::get('/reset', [UserController::class, 'resetAddress']);
    });

    // Product
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products');
        Route::get('/{slug}', [ProductController::class, 'detail'])->name('productDetail');
        Route::post('/variant', [ProductController::class, 'variant']);
        Route::post('/base_discount', [ProductController::class, 'base_discount']);
        Route::post('/incremental_discount', [ProductController::class, 'incremental_discount']);
        Route::get('/reloadSlider/{product_id}/{variant_id}', [ProductController::class, 'reloadSlider']);
    });

    // Cart
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::post('/', [CartController::class, 'store'])->name('cartStore');
        Route::get('/reloadCart', [CartController::class, 'reloadCart']);
        Route::post('/itemIncrease', [CartController::class, 'itemIncrease']);
        Route::post('/itemDecrease', [CartController::class, 'itemDecrease']);
        Route::post('/itemDelete', [CartController::class, 'itemDelete']);
        Route::get('/empty', [CartController::class, 'emptyCart']);
        Route::post('/couponCode', [CartController::class, 'couponCode'])->name('couponCode');
    });

    // Checkout
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/', [CheckoutController::class, 'store'])->name('checkoutStore');
    });

    // Payment
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment');
        Route::post('/', [PaymentController::class, 'store'])->name('paymentStore');
    });
});

Route::namespace('Auth')->prefix('admin')->name('admin.')->group(function () {
    // Login
    Route::get('/', [AdminLoginController::class, 'showLoginForm']);
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('loginSubmit');
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Password Update
    Route::get('/change-password', [AdminPasswordController::class, 'changePassword'])->name('changePassword');
    Route::post('/change-password', [AdminPasswordController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/reset-password', [AdminPasswordController::class, 'resetPassword'])->name('resetPassword');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/report', [App\Http\Controllers\Admin\DashboardController::class, 'report'])->name('dashboard.report');
    Route::post('dashboard/positionData', [App\Http\Controllers\Admin\DashboardController::class, 'positionData']);
    Route::post('dashboard/publishData', [App\Http\Controllers\Admin\DashboardController::class, 'publishData']);
    Route::post('dashboard/featuredData', [App\Http\Controllers\Admin\DashboardController::class, 'featuredData']);
    Route::post('dashboard/deleteData', [App\Http\Controllers\Admin\DashboardController::class, 'deleteData']);
    Route::post('dashboard/deleteImage', [App\Http\Controllers\Admin\DashboardController::class, 'deleteImage']);

    Route::middleware(['AdminAccess'])->group(function () {
        Route::resource('subadmin', App\Http\Controllers\Admin\SubadminController::class)->except(['show']);
        Route::resource('website', App\Http\Controllers\Admin\WebsiteController::class)->only(['index', 'edit', 'update']);
    });

    Route::resource('banner', App\Http\Controllers\Admin\BannerController::class)->except(['show']);
    Route::resource('about', App\Http\Controllers\Admin\AboutController::class)->only(['index', 'edit', 'update']);

    Route::resource('country', App\Http\Controllers\Admin\CountryController::class)->except(['show']);
    Route::post('country/position', [App\Http\Controllers\Admin\CountryController::class, 'position'])->name('country.position');

    Route::resource('state', 'App\Http\Controllers\Admin\StateController', ['except' => ['show']]);

    Route::resource('ticker', App\Http\Controllers\Admin\TickerController::class)->except(['show']);
    Route::post('ticker/position', 'App\Http\Controllers\Admin\TickerController@position')->name('ticker.position');

    Route::resource('category', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::post('category/position', [App\Http\Controllers\Admin\CategoryController::class, 'position'])->name('category.position');

    Route::resource('flavour', App\Http\Controllers\Admin\FlavourController::class)->except(['show']);
    Route::post('flavour/position', 'App\Http\Controllers\Admin\FlavourController@position')->name('flavour.position');

    Route::resource('strength', App\Http\Controllers\Admin\StrengthController::class)->except(['show']);
    Route::post('strength/position', 'App\Http\Controllers\Admin\StrengthController@position')->name('strength.position');

    Route::resource('label', App\Http\Controllers\Admin\LabelController::class)->except(['show']);
    Route::post('label/position', 'App\Http\Controllers\Admin\LabelController@position')->name('label.position');

    Route::resource('product', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
    Route::post('product/position', 'App\Http\Controllers\Admin\ProductController@position')->name('product.position');
    Route::post('product/showOnCart', 'App\Http\Controllers\Admin\ProductController@showOnCart')->name('product.showOnCart');
    Route::resource('product.images', App\Http\Controllers\Admin\ProductImageController::class)->except(['show']);
    Route::resource('product.variants', App\Http\Controllers\Admin\ProductVariantController::class)->except(['show']);
    Route::resource('product.reviews', App\Http\Controllers\Admin\ProductReviewController::class)->only(['index']);
    Route::resource('product.similar', ProductSimilarController::class)->except(['create', 'show']);
    Route::post('product-similar/position', [ProductSimilarController::class, 'position'])->name('product.similar.position');

    Route::resource('order', 'App\Http\Controllers\Admin\OrderController', ['except' => ['create', 'store', 'destroy']])->names(['show' => 'order.invoice']);

    Route::resource('promise', App\Http\Controllers\Admin\PromiseController::class)->except(['show']);
    Route::post('promise/position', 'App\Http\Controllers\Admin\PromiseController@position')->name('promise.position');

    Route::resource('process', App\Http\Controllers\Admin\ProcessController::class)->except(['show']);
    Route::post('process/position', 'App\Http\Controllers\Admin\ProcessController@position')->name('process.position');

    Route::resource('faq', App\Http\Controllers\Admin\FaqController::class)->except(['show']);
    Route::post('faq/position', 'App\Http\Controllers\Admin\FaqController@position')->name('faq.position');

    Route::resource('press-release', App\Http\Controllers\Admin\PressReleaseController::class)->except(['show']);
    Route::post('press-release/position', 'App\Http\Controllers\Admin\PressReleaseController@position')->name('press-release.position');

    Route::resource('award', App\Http\Controllers\Admin\AwardController::class)->except(['show']);
    Route::post('award/position', 'App\Http\Controllers\Admin\AwardController@position')->name('award.position');

    Route::resource('page', App\Http\Controllers\Admin\PageController::class)->except(['show']);
    Route::resource('page.banners', App\Http\Controllers\Admin\PageBannerController::class)->except(['show']);

    Route::resource('user', App\Http\Controllers\Admin\UserController::class);

    Route::get('userExport', [App\Http\Controllers\Admin\UserController::class, 'userExport'])->name('user.export');

    Route::resource('coupon', App\Http\Controllers\Admin\CouponController::class)->except('show')->names(['show' => 'coupon']);
    Route::resource('discount', App\Http\Controllers\Admin\DiscountController::class)->except('show')->names(['show' => 'discount']);

    Route::resource('store', App\Http\Controllers\Admin\StoreController::class)->only(['index']);
    Route::get('store/import', [App\Http\Controllers\Admin\StoreController::class, 'importView'])->name('store.importView');
    Route::post('store/importSave', [App\Http\Controllers\Admin\StoreController::class, 'import'])->name('store.import');
    Route::get('store/export', [App\Http\Controllers\Admin\StoreController::class, 'export'])->name('store.export');
    Route::get('store/template', [App\Http\Controllers\Admin\StoreController::class, 'downloadTemplate'])->name('store.template');

    Route::get('contact', 'App\Http\Controllers\Admin\EnquiryController@contact')->name('contact');
    Route::get('newsletter-subscription', 'App\Http\Controllers\Admin\EnquiryController@newsletterSubscription')->name('newsletterSubscription');
});

Route::get('/clear', function () {
    $commands = [
        'storage:link',
        'config:cache',
        'config:clear',
        'cache:clear',
        'route:clear',
        'view:clear',
        'auth:clear-resets',
        'event:clear',
        'queue:clear',
        'queue:flush',
        'schedule:clear-cache',
        'optimize'
    ];
    $output = [];
    $errors = [];
    foreach ($commands as $command) {
        try {
            Artisan::call($command);
            $output[$command] = Artisan::output();
        } catch (\Exception $e) {
            $errors[$command] = $e->getMessage();
        }
    }
    return $errors ? response()->json(['errors' => $errors], 500) : response()->json(['message' => 'All cache cleared successfully!']);
});
