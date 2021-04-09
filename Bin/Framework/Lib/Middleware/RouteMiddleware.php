<?php

use Bin\Framework\Lib\Route\Route;


require_once join(DIRECTORY_SEPARATOR,['App', 'routes','web.php']);
require_once join(DIRECTORY_SEPARATOR,['App', 'routes','api.php']);


Route::done();