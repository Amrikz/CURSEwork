<?php

use Bin\Framework\Lib\Random\RandomVars;

$phrases = [
    "Ну и название...",
    "Оно работает!",
    "Почему бы и нет)",
    "???",
    "PROFIT!",
];
?>

<body>
    <header>
    </header>
    <section id="content">
        <p>CURSEWORK</p>
        <p id="phrase"><?php echo RandomVars::StrFromArr($phrases) ?></p>
    </section>
</body>
