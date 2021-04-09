<?php


use App\Jobs\Auth\Auth;
use Bin\Framework\Lib\Logging\Messages;

$messages = Messages::GetAsStatus();
$messages[] = Auth::GetArrStatus();

foreach ($messages as $message)
{
    if ($message['status'] !== null)
    {
        if ($message['status'] === true)
        {
            $message = $message['message'];
            ?>
            <div style='
        font-size: large;
        background: forestgreen;
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
        elseif ($message['status'] == false)
        {
            if ($message['required']) $message = "Required: ".$message['required'];
            else $message = $message['message'];
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
    }
}