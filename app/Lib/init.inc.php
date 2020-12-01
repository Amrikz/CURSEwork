<?php
require_once 'app'.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.'Config.class.php';
require_once 'app'.DIRECTORY_SEPARATOR.'Lib'.DIRECTORY_SEPARATOR.'Autoload.class.php';

use App\Lib\Autoload;
use App\Lib\Logging\Logger;

Autoload::standardMode();
//Autoload::dynamicMode();

session_start();

Logger::Initialize();