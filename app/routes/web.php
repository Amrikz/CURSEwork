<?php

use App\Lib\Route\Route;


Route::get('',App\Controllers\HomeController::class,'index');
Route::get('test',App\Controllers\HomeController::class,'test');
Route::get('test/*/~',App\Controllers\HomeController::class,'test');

Route::done();
