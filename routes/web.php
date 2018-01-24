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
    Route::any('position/create/{parent?}', 'PositionController@create');

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

    // Position
    Route::group(['prefix' => 'position'], function() {
        Route::any('', 'PositionController@index')->name('position');
        Route::get('{position}', 'PositionController@show')->name('position.show');
        Route::get('/create/{parent?}', 'PositionController@create')->name('position.create');
        Route::post('store', 'PositionController@store')->name('position.store');
        Route::get('edit/{position}', 'PositionController@edit')->name('position.edit');
        Route::post('update', 'PositionController@update')->name('position.update');
        Route::delete('delete', 'PositionController@delete')->name('position.delete');
    });
});

