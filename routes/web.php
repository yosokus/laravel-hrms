<?php

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name('home');

    Route::resources([
        'department' => 'DepartmentController',
        'position' => 'PositionController',
        'employee' => 'EmployeeController',
    ]);

    // Override resource create route
    Route::any('department/create/{parent?}', 'DepartmentController@create')->name('department.create');
    Route::any('position/create/{parent?}', 'PositionController@create')->name('position.create');
});

