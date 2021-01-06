<?php
require_once 'Config'.DIRECTORY_SEPARATOR.'AppConfig.class.php';
require_once 'app'.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.'Autoload.class.php';

use App\Lib\Autoload;
use App\Lib\File\Filename;
use App\Lib\Logging\Logger;

session_start();

Autoload::safeMode();
Logger::Initialize();

Autoload::dynamicMode();


Logger::Info(Filename::Relative(__FILE__), "Initialization complete", true);