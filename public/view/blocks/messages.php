<?php


use App\Jobs\Auth\Auth;
use App\Lib\Logging\Messages;
use App\Lib\Logging\Status;

$messages = Messages::GetAsStatus();
$messages[] = Auth::GetArrStatus();

$errors = Status::StatusCheck($messages);

foreach ($errors as $error)
{
    if ($error['required']) $message = "Required: ".$error['required'];
    else $message = $error['message'];
    ?>
    <div style='
        font-size: large;
        background: red;
        color: #ffffff;
        display: flex;
        justify-content: center;
        max-width: 1170px;
        margin: 10px auto;
    '>
        <?=$message?>
    </div>
    <?php
}