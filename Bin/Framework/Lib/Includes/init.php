<?php
require_once join(DIRECTORY_SEPARATOR,['Config','AppConfig.class.php']);
require_once join(DIRECTORY_SEPARATOR,[FRAMEWORK_DIR,'Lib','Autoload.class.php']);

use Bin\Framework\Lib\Autoload;
use Bin\Framework\Lib\File\Filename;
use Bin\Framework\Lib\Handlers\ErrorHandler;
use Bin\Framework\Lib\Handlers\ExceptionHandler;
use Bin\Framework\Lib\Logging\Logger;
use Bin\Framework\Lib\Request\Request;
use Config\AppConfig;

session_start();
error_reporting(AppConfig::ERROR_REPORTING);

Autoload::safeMode();

Logger::Initialize();
if (AppConfig::LOGGER_MUTE) Logger::Mute();

Autoload::dynamicMode();

require_once join(DIRECTORY_SEPARATOR,[FRAMEWORK_DIR,'Lib','Includes','Helpers.php']);

ExceptionHandler::Set();
ErrorHandler::Set();
Request::get(true);

Logger::Info(Filename::Relative(__FILE__), "Initialization complete", true);