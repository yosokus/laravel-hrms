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

    // TODO fix route
    Route::any('department/create/{parent?}', 'DepartmentController@create');

    // Department
    Route::group(['prefix' => 'department'], function() {
        Route::any('', 'DepartmentController@index')->name('department');
        Route::get('{department}', 'DepartmentController@show')->name('department.show');
        Route::get('create/{parent?}', 'DepartmentController@create')->name('department.create');
        Route::post('store', 'DepartmentController@store')->name('department.store');
        Route::get('edit/{department}', 'DepartmentController@edit')->name('department.edit');
        Route::post('update', 'DepartmentController@update')->name('department.update');
        Route::delete('delete', 'DepartmentController@delete')->name('department.delete');
    });
});

