<?php


namespace App\Models;


interface ModelInterface
{
    public function Select();

    public function Create();

    public function Update();

    public function Delete();
}