<?php

use App\Lib\Route\Url;

$params = $GLOBALS['foot_params'];

Url::addPrefixToHref($params['scripts'], 'src=');
$params['scripts'] ? forEachEcho($params['scripts']) : null;
$params['abs_scripts'] ? forEachEcho($params['abs_scripts']) : null;

