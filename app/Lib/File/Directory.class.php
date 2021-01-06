<?php


namespace App\Lib\File;


class Directory
{
    public $path;


    public function __construct($dir_path)
    {
        $this->path = PROJECT_DIR.$dir_path;
        return $this->CreateCheck($this->path);
    }


    public function CreateCheck ($dir_path)
    {
        if (is_dir($dir_path)) return true;
        return mkdir($dir_path, 0777, true);
    }


    public function Delete ($dir_path)
    {

    }
}