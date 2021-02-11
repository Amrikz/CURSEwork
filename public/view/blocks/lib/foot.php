<?php

use App\Lib\Route\Url;

$params = $GLOBALS['foot_params'];

$params['scripts']  = [
];

Url::addPrefixToHref($params['scripts'], 'src=');
$params['scripts'] ? forEachEcho($params['scripts']) : null;

