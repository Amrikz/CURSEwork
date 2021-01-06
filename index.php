<?php

/*
 * Define project root directory
 */
define('PROJECT_DIR', __DIR__);

/*
 * Init modules in one place
 */
require_once 'app' . DIRECTORY_SEPARATOR . 'Lib' . DIRECTORY_SEPARATOR . 'init.inc.php';

/*
 * Routes middleware
 */
require_once 'app'.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'web.php';



/*
 * GLOBAL_TODO
 ~ TODO: Make Messaging/Logging systems.
 * TODO: Make Security transfer class (repository) and wrapper pipelines.
 + TODO: Make Normal Models/Controllers system with BaseModel class and Model interface.
 * TODO: Make "easy for use" Models call to Database.
 + TODO: Rename vendor and its namespace to lib.
 * TODO: Move index.php to /public.
 * TODO: Migrate DB from Mysqli to PDO.
 + TODO: Refactor Config classes AND move them to /config
 * TODO: Routeworks. Make routes vary get/post
 * TODO: Get rid of mess. Clean all.
*/