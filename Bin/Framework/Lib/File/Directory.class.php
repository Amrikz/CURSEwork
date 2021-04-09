<?php


namespace Bin\Framework\Lib\File;


class Directory
{
    public $path;


    public function __construct($dir_path, $absolute = false)
    {
        if (!$absolute) $this->path = PROJECT_DIR.$dir_path;
        return $this->CreateCheck($this->path);
    }


    public function CreateCheck ($dir_path)
    {
        if (is_dir($dir_path)) return true;
        return mkdir($dir_path, 0777, true);
    }


    public function Delete ($dir_path = null)
    {
        if (!$dir_path) $dir_path = $this->path;
        $files = array_diff(scandir($dir_path), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir_path/$file")) ? self::Delete("$dir_path/$file") : unlink("$dir_path/$file");
        }
        return rmdir($dir_path);
    }


    public static function AllInDirectory($dir_path)
    {
        if ($handle = opendir($dir_path))
        {
            $res = null;
            while (false !== ($entry = readdir($handle)))
            {
                $res[] = $entry;
            }
            closedir($handle);
            return $res;
        }
        return false;
    }
}