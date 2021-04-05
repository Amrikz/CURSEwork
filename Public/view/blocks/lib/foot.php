<?php


$params = $GLOBALS['foot_params'];

$params['scripts'] ? forEachEcho($params['scripts']) : null;
$params['abs_scripts'] ? forEachEcho($params['abs_scripts']) : null;

