<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Distributor\ChangePasswordController;
use App\Http\Controllers\Auth\FranchiseLoginController;
use App\Http\Controllers\Auth\FranchiseRegisterController;
use App\Http\Controllers\Franchise\PlanPaymentController;

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

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'DONE'; //Return anything
});
Route::get('/make-model', function () {
    $exitCode = Artisan::call('make:migration add_sub_parent_id_column');
    return Artisan::output(); //Return anything
});

Route::get('/routeList', function () {
    $exitCode = Artisan::call('route:list');
    return Artisan::output(); //Return anything
});

Route::get('/seed', function () {
    $exitCode = Artisan::call('db:seed');
    return 'DONE'; //Return anything
});

//create symbolic link for storage
Route::get('/symlink', function () {
    return view('symlink');
});

Route::get('/', function () {
    return view('front.index');
});
Route::get('about', function () {
    return view('front.about');
});
Route::get('product', function () {
    return view('front.product');
});
Route::get('contact', function () {
    return view('front.contact');
});
Route::get('viewproduct', function () {
    return view('front.viewproduct');
});
Route::get('document', function () {
    return view('front.document');
});
Route::get('plan', function () {
    return view('front.plan');
});

Auth::routes();

Route::post('/register/submit', [App\Http\Controllers\RegisterController::class, 'store'])->name('register.submit');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\Auth\RegisterController::class, 'search'])->name('search');
Route::get('/search-sponsor', [App\Http\Controllers\RegisterController::class, 'searchSponsor'])->name('search.sponsor');

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::resource('/distributor', DistributorController::class);
    Route::resource('/franchise', FranchiseController::class);
    Route::get('/franchise/status/{id}', [FranchiseController::class, 'status']);
    Route::get('company-tree', [DistributorController::class, 'companyTree'])->name('company-tree');
    Route::get('orders', [FranchiseController::class, 'orders'])->name('orders');
    Route::get('/order/status/{id}', [FranchiseController::class, 'orderStatus']);
    Route::get('/users/kyc-verifications', [DistributorController::class, 'distributorKycVerification'])->name('users.kyc-verification');
    Route::get('/franchises/kyc-verification', [FranchiseController::class, 'franchiseKycVerification'])->name('franchise.kyc-verification');
    Route::get('/users/kyc-status/{id}', [DistributorController::class, 'kycStatus']);
    Route::get('/franchises/kyc-status/{id}', [FranchiseController::class, 'kycStatus']);
    Route::get('/income-settlement', [DistributorController::class, 'incomeSettlement'])->name('income-settlement');
    Route::post('/generate-income-settlement', [DistributorController::class, 'generateIncomeSettlement'])->name('generate-income-settlement');
    Route::get('/salary-settlement', [DistributorController::class, 'salarySettlement'])->name('salary-settlement');
    Route::post('/generate-salary-settlement', [DistributorController::class, 'generateSalarySettlement'])->name('generate-salary-settlement');
    Route::get('/reward-settlement', [DistributorController::class, 'rewardSettlement'])->name('reward-settlement');
    Route::post('/generate-reward-settlement', [DistributorController::class, 'generateRewardSettlement'])->name('generate-reward-settlement');
    Route::get('/wallet', [DistributorController::class, 'adminWallet'])->name('wallet');
    Route::get('/joining-details', [DistributorController::class, 'joiningDetails'])->name('joining-detail.index');
    Route::get('/income-settlement/{id}', [DistributorController::class, 'viewIncomeSettlement'])->name('income-settlement.view');
    Route::get('/salary-settlement/{id}', [DistributorController::class, 'viewSalarySettlement'])->name('salary-settlement.view');
    Route::get('/paid-income-settlement/{id}', [DistributorController::class, 'viewPaidIncomeSettlement'])->name('income-settlement.paid');
    Route::get('/paid-salary-settlement/{id}', [DistributorController::class, 'viewPaidSalarySettlement'])->name('salary-settlement.paid');
    Route::post('/settlement/status', [DistributorController::class, 'settlementStatus'])->name('settlement.status');
    Route::get('/reward-settlement/{id}', [DistributorController::class, 'viewRewardSettlement'])->name('reward-settlement.view');
    Route::get('/paid-reward-settlement/{id}', [DistributorController::class, 'viewPaidRewardSettlement'])->name('reward-settlement.paid');

});


Route::prefix('distributor')->name('distributor.')->group(function() {
    Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::resource('/joiners', App\Http\Controllers\Distributor\DistributorController::class);
    Route::get('/search', [App\Http\Controllers\Distributor\DistributorController::class, 'search'])->name('search');
    Route::get('/search/sponsor', [App\Http\Controllers\Distributor\DistributorController::class, 'searchSponsor'])->name('search.sponsor');
    Route::get('/treeview', [App\Http\Controllers\Distributor\DistributorController::class, 'treeview'])->name('treeview');
    Route::get('/welcomeLetter', [App\Http\Controllers\Distributor\DistributorController::class, 'welcomeLetter'])->name('welcomeLetter');
    Route::get('/identityCard', [App\Http\Controllers\Distributor\DistributorController::class, 'identity'])->name('identityCard');
    Route::get('my-business', [App\Http\Controllers\Distributor\DistributorController::class, 'myBusiness'])->name('my-business');
    Route::resource('/change-password', ChangePasswordController::class);
    Route::get('/kyc-document', [App\Http\Controllers\Distributor\DistributorController::class, 'kycDocument'])->name('kyc-document');
    Route::post('/kyc-document/upload', [App\Http\Controllers\Distributor\DistributorController::class, 'uploadKycDocument'])->name('kyc-document.upload');
    Route::get('/my-income', [App\Http\Controllers\Distributor\DistributorController::class, 'myIncome'])->name('my-income');
    Route::get('/income', [App\Http\Controllers\Distributor\DistributorController::class, 'incomeDetails'])->name('income');
    Route::get('/salary', [App\Http\Controllers\Distributor\DistributorController::class, 'salaryDetails'])->name('salary');
    Route::get('/reward', [App\Http\Controllers\Distributor\DistributorController::class, 'rewardDetails'])->name('reward');
    Route::get('/my-wallet', [App\Http\Controllers\Distributor\DistributorController::class, 'myWallet'])->name('my-wallet');
    Route::get('/payment-settlement', [App\Http\Controllers\Distributor\DistributorController::class, 'paymentSettlement'])->name('payment-settlement');

});

Route::prefix('franchise')->name('franchise.')->group(function() {
    Route::get('/register', [FranchiseRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FranchiseRegisterController::class, 'register'])->name('register.submit');
    Route::get('/login', [FranchiseLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FranchiseLoginController::class, 'login'])->name('login.submit');
    Route::get('/', [App\Http\Controllers\Auth\FranchiseController::class, 'index'])->name('dashboard');
    Route::get('logout', [FranchiseLoginController::class, 'logout'])->name('logout');
    Route::get('/orders', [App\Http\Controllers\Franchise\FranchiseController::class, 'order'])->name('order');
    Route::post('/order/store', [App\Http\Controllers\Franchise\FranchiseController::class, 'orderStore'])->name('order.store');
    Route::get('/product-payment', [App\Http\Controllers\Franchise\FranchiseController::class, 'productPayment'])->name('product-payment');
    Route::get('/search', [App\Http\Controllers\Franchise\FranchiseController::class, 'search'])->name('search');
    Route::post('/product-payment', [App\Http\Controllers\Franchise\FranchiseController::class, 'storeProductPayment'])->name('product-payment.store');
    Route::get('/product-payment/{id}', [App\Http\Controllers\Franchise\FranchiseController::class, 'viewProductPayment'])->name('product-payment.view');
    Route::get('/kyc-document', [App\Http\Controllers\Franchise\FranchiseController::class, 'kycDocument'])->name('kyc-document');
    Route::post('/kyc-document/upload', [App\Http\Controllers\Franchise\FranchiseController::class, 'uploadKycDocument'])->name('kyc-document.upload');
    Route::get('/profile', [App\Http\Controllers\Franchise\FranchiseController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [App\Http\Controllers\Franchise\FranchiseController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [App\Http\Controllers\Franchise\FranchiseController::class, 'updatePassword'])->name('password.update');
     Route::get('/payment', [App\Http\Controllers\Franchise\FranchiseController::class, 'payment'])->name('payment');
    Route::get('/payment-search', [App\Http\Controllers\Franchise\FranchiseController::class, 'searchDistributorDetails'])->name('payment-search');
    Route::post('/send-otp', [App\Http\Controllers\Franchise\FranchiseController::class, 'sendOtp'])->name('product-payment.send-otp');
    Route::post('/product-payment/submit', [App\Http\Controllers\Franchise\FranchiseController::class, 'submitProductPayment'])->name('product-payment.submit');
    Route::resource('plan-payment', PlanPaymentController::class);
});