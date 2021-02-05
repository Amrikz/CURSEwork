<?php


namespace App\Lib\File;


use App\Lib\Errors\ErrProcessor;
use Config\AppConfig;

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


    public function Name()
    {
        return Filename::NameExt($this->path);
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


    public static function Upload($path, $filename, $files_arr = null)
    {
        if (!$files_arr) $files_arr = $_FILES;
        foreach ($files_arr as $key => $value)
        {
            if (!$value["tmp_name"])
            {
                ErrProcessor::MakeError('Error in upload. No tmp_name');
                return false;
            }

            if (in_array($value['type'], AppConfig::UPLOAD_TYPES))
            {
                $filepath = $path.DIRECTORY_SEPARATOR.$filename;

                if (in_array($filepath, Directory::AllInDirectory($path)))
                {
                    ErrProcessor::MakeError('Error in upload. File with this name exist');
                    return false;
                }

                $upload = move_uploaded_file($value["tmp_name"], $filepath);
                if ($upload) return true;
                return false;
            }
            else return false;
        }
        return false;
    }
}