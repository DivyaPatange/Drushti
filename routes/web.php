<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Admin\DistributorController;
use App\Http\Controllers\Distributor\ChangePasswordController;

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

Route::get('/', function () {
    return view('distributor.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::resource('/distributor', DistributorController::class);
});

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::resource('/distributor', DistributorController::class);
    Route::get('company-tree', [DistributorController::class, 'companyTree'])->name('company-tree');
});

Route::prefix('distributor')->name('distributor.')->group(function() {
    Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::resource('/joiners', App\Http\Controllers\Distributor\DistributorController::class);
    Route::get('/search', [App\Http\Controllers\Distributor\DistributorController::class, 'search'])->name('search');
    Route::get('/treeview', [App\Http\Controllers\Distributor\DistributorController::class, 'treeview'])->name('treeview');
    Route::resource('/change-password', ChangePasswordController::class);
    Route::get('/kyc-document', [App\Http\Controllers\Distributor\DistributorController::class, 'kycDocument'])->name('kyc-document');
    Route::post('/kyc-document/upload', [App\Http\Controllers\Distributor\DistributorController::class, 'uploadKycDocument'])->name('kyc-document.upload');
});