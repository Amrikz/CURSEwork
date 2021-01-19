<?php

use Config\AppConfig;

$params = $GLOBALS['header_params'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php echo AppConfig::DBCHARSET?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $params['title'] ? $params['title'] : "CURSEWORK"?></title>

    <!-- load stylesheets -->
    <?php $params['links'] ? forEachEcho($params['links']) : null?>

    <!-- load js scripts -->
    <?php $params['scripts'] ? forEachEcho($params['scripts']) : null?>

    <!-- load custom style -->
    <?php $params['style'] ? forEachEcho($params['style']) : null?>
</head>