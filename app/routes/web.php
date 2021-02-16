<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Lib\Route\Route;


Route::get('',HomeController::class,'index');

Route::get('admin',AdminController::class,'index');