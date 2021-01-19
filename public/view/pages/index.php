<?php

use App\Lib\File\View;
use App\Lib\Random\RandomVars;


$phrases = [
    "Ну и название...",
    "Оно работает!",
    "Почему бы и нет)",
    "???",
    "PROFIT!",
];


$params =& $GLOBALS['head_params'];

$params['title']    = "Index";
$params['links']    = [
    "<link rel='stylesheet' href='/public/css/welcome.css'>",
];
$params['scripts']  = [
];
$params['style']    = [
];

View::ViewDir('blocks'.DIRECTORY_SEPARATOR.'head.php');
?>

<body>
    <header>
    </header>
    <section id="content">
        <p>CURSEWORK</p>
        <p id="phrase"><?php echo RandomVars::StrFromArr($phrases) ?></p>
    </section>
</body>

<?php
View::ViewDir('blocks'.DIRECTORY_SEPARATOR.'footer.php');