<?php

use App\Http\Controllers\Company\CompanyController;
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

Route::get('/otp', function () {
    return view('home');
});


Route::middleware('auth')->group(function () {

    Route::get('/', 'Company\CompanyController@index');
    Route::get('/home', 'Company\CompanyController@index')->name('home');

    Route::resource('company', 'Company\CompanyController');
    Route::post('company/search', 'Company\CompanyController@searchData')->name('com-search');
    Route::post('com-download', 'Company\CompanyController@download')->name('com-download');


    Route::resource('employee', 'Employee\EmployeeController');
    Route::post('employee/search', 'Employee\EmployeeController@searchData')->name('emp-search');
    Route::post('emp-download', 'Employee\EmployeeController@download')->name('emp-download');
});
