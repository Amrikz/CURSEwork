<?php

use App\Controllers\HomeController;
use App\Controllers\AdminController;
use App\Lib\Route\Route;

# ['auth' => ["*"]] in params, to activate token protection. Instead '*' may be array of roles.

Route::any('',HomeController::class,'index');

Route::any('admin',AdminController::class,'index');