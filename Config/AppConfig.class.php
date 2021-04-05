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
    const DBHOST    = '127.0.0.1';
    const DBNAME    = '';
    const DBLOGIN   = 'root';
    const DBPASS    = 'root';
    const DBCHARSET = 'utf8';

    const REPOSITORY_DB_CLASS       = PdoDB::class;
    const REPOSITORY_STATEMENT_MODE = true;


    //Files
    //Relative path to /Public
    const PUBLIC_DIR    = DIRECTORY_SEPARATOR.'Public'.DIRECTORY_SEPARATOR;
    //Relative path to /view
    const VIEW_DIR      = self::PUBLIC_DIR.'view'.DIRECTORY_SEPARATOR;
    //Relative path to /logs
    const LOGS_DIR      = DIRECTORY_SEPARATOR.'Data'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;


    //Allowed file upload types
    const UPLOAD_TYPES  = [
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/webp',
        'image/img'
    ];


    //Escaped chars
    const ESCAPED_CHARS = [
        "'",'"'
    ];


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


    //Request
    const REQUEST_DEFAULT_OVERRIDE_POST = true;


    //Response
    const RESPONSE_TYPE = "JSON" /*"ARR"*/;

}