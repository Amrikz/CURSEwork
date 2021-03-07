<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Lib\Route\Route;


Route::any('',HomeController::class,'index');

Route::any('admin',AdminController::class,'index');