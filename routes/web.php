<?php

use App\Http\Controllers\ContactPersonController;
use App\Http\Controllers\ProjectController;
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

Route::get('/', function(){
    return redirect()->route('projects.index'); 
});

Route::controller(ProjectController::class)->name('projects.')->prefix('projects')
->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{project}', 'show')->name('show');
    Route::put('/{project}', 'update')->name('update');
    Route::delete('/{project}', 'delete')->name('delete');
});


Route::controller(ContactPersonController::class)->name('contact-person.')->prefix('contact-person')
->group(function () {
    Route::put('/{contactPerson}', 'update')->name('update');
    Route::delete('/{contactPerson}', 'delete')->name('delete');
});