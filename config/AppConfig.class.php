<?php


namespace Config;


use App\Lib\Database\PdoDB;

class AppConfig
{
    //APP
    const DEBUG_MODE        = true;
    const ERROR_REPORTING   = E_ALL;


    //Logger
    const LOGGER_MUTE = false;


    //Database
    const DBHOST    = '';
    const DBLOGIN   = '';
    const DBPASS    = '';
    const DBNAME    = '';
    const DBCHARSET = 'utf8';

    const REPOSITORY_DB_CLASS       = PdoDB::class;
    const REPOSITORY_STATEMENT_MODE = true;


    //Files
    //Relative path to /view
    const VIEW_DIR = DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR;
    //Relative path to /logs
    const LOGS_DIR = DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;


    //Routing
    const URL_ARG_CHAR      = '*';
    const URL_VARY_ARG_CHAR = '~';


    //Autoload
    const AUTOLOAD_BLACKLIST = [
        //Banned classes
        ""
    ];
    const DYNAMIC_AUTOLOAD_EXTENSIONS = [
        ".class.php",
        ".php",
        ".trait.php",
        ".interface.php"
    ];
}