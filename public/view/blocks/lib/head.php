<?php

use App\Lib\Route\Url;
use Config\AppConfig;

$params = $GLOBALS['head_params'];
Url::addPrefixToHref($params['links']);
Url::addPrefixToHref($params['scripts'], 'src=');
?>


<!DOCTYPE html>
<html class="no-js" lang="">
    <head>
        <meta charset="<?php echo AppConfig::DBCHARSET?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?php echo $params['title'] ? $params['title'] : "CURSEWORK"?></title>

        <!-- load absolute links -->
        <?php $params['abs_links'] ? forEachEcho($params['abs_links']) : null?>

        <!-- load stylesheets -->
        <?php $params['links'] ? forEachEcho($params['links']) : null?>

        <!-- load js scripts -->
        <?php $params['scripts'] ? forEachEcho($params['scripts']) : null?>

        <!-- load custom style -->
        <?php $params['style'] ? forEachEcho($params['style']) : null?>
    </head>