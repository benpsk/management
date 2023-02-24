<?php

use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

// Auth::routes();

Route::get('/login', 'HomeController@showLogin')->middleware('guest')->name('login');
Route::post('/login', 'HomeController@login')->name('login');
Route::post('/logout', 'HomeController@logout')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', [CompanyController::class, 'index']);
    Route::get('/home', [CompanyController::class, 'index'])->name('home');

    Route::resource('company', CompanyController::class);
    Route::post('company/search', [CompanyController::class, 'searchData'])->name('com-search');
    Route::post('com-download', [CompanyController::class, 'download'])->name('com-download');


    Route::resource('employee', EmployeeController::class);
    Route::post('employee/search', [EmployeeController::class, 'searchData'])->name('emp-search');
    Route::post('emp-download', [EmployeeController::class, 'download'])->name('emp-download');
});


Route::get('download', [HomeController::class, 'download']);
