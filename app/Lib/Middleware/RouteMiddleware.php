<?php

use App\Lib\Route\Route;


require_once join(DIRECTORY_SEPARATOR,['app', 'routes','web.php']);
require_once join(DIRECTORY_SEPARATOR,['app', 'routes','api.php']);


Route::done();