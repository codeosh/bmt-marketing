<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\PostTemplateController;
use App\Http\Controllers\ReplyTemplateController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ProspectsController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\GuidesController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Models\QuotationItem;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');



    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

//middleware sa admin and user ge isa nalaman og group
Route::middleware(['auth', 'verified'])->group(function () {


    //admin routes
    Route::middleware(['role:admin'])->group(function () {

        // Route::get('/admin-dashboard', function () {
        //     return view('admin.admin-dashboard');
        // })->name('admin.dashboard');
        Route::post('/admin-register', [RegisteredUserController::class, 'store']);

        //bulletin
        Route::resource('admin-bulletin', BulletinController::class);
        Route::get('/fetch-bulletins', [BulletinController::class, 'getAdminBulletins']);

        //pricelist
        Route::resource('admin-priceList', PricelistController::class);
        Route::get('/fetch-pricelist', [PricelistController::class, 'getAdminPricelist']) // Admin-only;
            ->name('admin.fetch.pricelist');

        //postTemplate
        Route::resource('admin-postTemplate', PostTemplateController::class);
        Route::get('/fetch-post-template', [PostTemplateController::class, 'getAdminPostTemplate']);

        //replyTemplate
        Route::resource('admin-replyTemplate', ReplyTemplateController::class);
        Route::get('/fetch-replyTemplate', [ReplyTemplateController::class, 'getAdminReplyTemplate']);

        //insight
        Route::resource('admin-insight', InsightController::class);
        Route::get('/fetch-insight', [InsightController::class, 'getAdminInsight']);

        //quotation
        Route::resource('admin-quotation', QuotationController::class);
        Route::get('/get-latest-quotation', function () {
            $latestQuotation = QuotationItem::latest('quotation_no')->first();
            $newQuotationNo = $latestQuotation ? $latestQuotation->quotation_no + 1 : 10001;
            return response()->json(['quotation_no' => $newQuotationNo]);
        });
        Route::post('/update-image/{id}', [QuotationController::class, 'updateImage']);
        Route::put('/CopyQuotation', [QuotationController::class, 'Copy']); // for copy quotation

        //guides
        Route::resource('admin-guides', GuidesController::class);
        Route::get('/fetch-guides', [GuidesController::class, 'getAdminguides']);

        Route::resource('admin-accounts', AccountController::class);
        Route::resource('admin-prospects', ProspectsController::class);
        Route::get('/Dashboard-Pages', function () {
            return view('pages.dashboard');
        })->name('admin-dashboard-page');
    });


    //user routes
    Route::middleware(['role:user'])->group(function () {

        // Route::get('/user-dashboard', function () {
        //     return view('user.user-dashboard');
        // })->name('user.dashboard');

        //bulletin
        Route::resource('user-bulletin', BulletinController::class);
        Route::get('/fetch-user-bulletins', [BulletinController::class, 'getUserBulletins']);

        //pricelist
        Route::resource('user-priceList', PricelistController::class);
        Route::get('/fetch-user-pricelist', [PricelistController::class, 'getUserPricelist']) // User-only;
            ->name('user.fetch.pricelist');

        //postTemplate
        Route::resource('user-postTemplate', PostTemplateController::class);
        Route::get('/fetch-user-post-template', [PostTemplateController::class, 'getUserPostTemplate']);

        //replyTemplate
        Route::resource('user-replyTemplate', ReplyTemplateController::class);
        Route::get('/fetch-user-replyTemplate', [ReplyTemplateController::class, 'getUserReplyTemplate']);

        //insight
        Route::resource('user-insight', InsightController::class);
        Route::get('/fetch-user-insight', [InsightController::class, 'getUserInsight']);

        //guides
        Route::resource('user-guides', GuidesController::class);
        Route::get('/fetch-user-guides', [GuidesController::class, 'getUserguides']);

        //quotation
        Route::resource('user-quotation', QuotationController::class);

        Route::resource('user-accounts', AccountController::class);
        Route::resource('user-accounts', AccountController::class);
        Route::resource('user-prospects', ProspectsController::class);

        Route::get('/Dashboard-Page', function () {
            return view('user-pages.dashboard');
        })->name('user-dashboard-page');
    });
});
