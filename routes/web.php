<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth']], function() {
    // your routes
});
Route::get('pokerhands','PokerHandsController@get')->name('pokerhands');
//
Route::get('uploadpokerhands', function () {
    return view('uploadpokerhands');
})->name('uploadpokerhands');


Route::post('file-upload', 'FileUploadController@fileUploadPost')->name('file.upload.post');