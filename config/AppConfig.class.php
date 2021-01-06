<?php


namespace Config;


class AppConfig
{
    //Database
    const DBHOST   = '127.0.0.1';
    const DBLOGIN  = 'root';
    const DBPASS   = 'root';
    const DBNAME   = 'cinemabase';


    //Files
    //Relative path to /view
    const VIEW_DIR = DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR;
    //Relative path to /logs
    const LOGS_DIR = DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;


    //Routing
    const URL_ARG_CHAR = '*';
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