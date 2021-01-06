<?php


namespace App\Lib\File;


class File
{
    public $file;
    public $path;


    public function __construct($filepath,$mode = 'a+')
    {
        $this->path = PROJECT_DIR.$filepath;
        $this->file = $this->Open($this->path,$mode);
        return $this->file;
    }


    public function Close()
    {
        return fclose($this->file);
    }


    public function Open($path = null,$mode = 'r+')
    {
        if ($path == null) $file = fopen($this->path,$mode.'b');
        else $file = fopen($path,$mode.'b');
        return $file;
    }


    public function Delete()
    {
        $this->file = null;
        return unlink($this->path);
    }


    public function Put($data, $flags = FILE_APPEND)
    {
        return file_put_contents($this->path,$data, $flags);
    }


    public static function Create($path)
    {
        return fopen(PROJECT_DIR.$path,'a+b');
    }
}