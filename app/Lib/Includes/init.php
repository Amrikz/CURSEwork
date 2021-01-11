<?php
require_once join(DIRECTORY_SEPARATOR,['Config', 'AppConfig.class.php']);
require_once join(DIRECTORY_SEPARATOR,['app','Lib','Autoload.class.php']);

use App\Lib\Autoload;
use App\Lib\File\Filename;
use App\Lib\Handlers\ErrorHandler;
use App\Lib\Handlers\ExceptionHandler;
use App\Lib\Logging\Logger;
use Config\AppConfig;

session_start();
error_reporting(AppConfig::ERROR_REPORTING);

Autoload::safeMode();
Logger::Initialize();

Autoload::dynamicMode();

require_once join(DIRECTORY_SEPARATOR,['app','Lib','Includes','Helpers.php']);

ExceptionHandler::Set();
ErrorHandler::Set();


Logger::Info(Filename::Relative(__FILE__), "Initialization complete", true);