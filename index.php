<?php

/*
 * COURSEWORK mini-Framework
 * 2020-2021 By Rikz.
 * https://github.com/Amrikz/CURSEwork
*/


/*
 * Define project root directory
 */
define('PROJECT_DIR', __DIR__);

/*
 * Init modules in one place
 */
require_once join(DIRECTORY_SEPARATOR,['app','Lib','Includes','init.php']);

/*
 * Routes middleware
 */
require_once join(DIRECTORY_SEPARATOR,['app','Lib','Middleware','RouteMiddleware.php']);



/*
 * GLOBAL_TODO
 ~ TODO: Make Messaging/Logging systems.
 ~ TODO: Make Security transfer classes (repository) and wrapper pipelines.
 + TODO: Make Normal Models/Controllers system with BaseModel class and Model interface.
 ~ TODO: Make "easy for use" Models call to Database.
 + TODO: Rename vendor and its namespace to lib.
 * TODO: Move index.php to /public.
 + TODO: Migrate DB from Mysqli to PDO.
 + TODO: Refactor Config classes AND move them to /config.
 * TODO: Routeworks. Make routes vary get/post. Make api.php links start with /api.
 * TODO: Get rid of mess. Clean all.
 ~ TODO: MIDDLEWARES. Work on it.
 + TODO: Handlers. Error and exception handlers.
 + TODO: Add Helper functions.
*/