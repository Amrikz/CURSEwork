<?php


namespace Bin\Framework\Lib\File;


use Bin\Framework\Lib\Errors\ErrProcessor;
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


    public function Rename($new_path)
    {
        $name       = Filename::NameExt($new_path);
        $new_path   = Filename::Absolute($new_path);

        if ($this->path == $new_path) return false;

        if (in_array($name, Directory::AllInDirectory(Filename::PathWithoutName($new_path))))
        {
            ErrProcessor::MakeError('Error in upload. File with this name exist');
            return false;
        }
        if (rename($this->path,$new_path))
        {
            $this->Delete();
            $this->Open($new_path);
        }
        return true;
    }


    //STATIC//


    public static function Create($path)
    {
        return fopen(PROJECT_DIR.$path,'a+b');
    }


    /**
     * Upload all given files to server.
     * Tip: $files_arr = [$filename => [$file]]
     *
     * @param $abs_path
     * @param array $files_arr
     * @param bool $create_dir
     * @return bool
     */
    public static function Upload($abs_path, array $files_arr, $create_dir = false)
    {
        foreach ($files_arr as $key => $value)
        {
            if (!$value["tmp_name"])
            {
                ErrProcessor::MakeError('Error in upload. No tmp_name');
                return false;
            }

            if (in_array($value['type'], AppConfig::UPLOAD_TYPES))
            {
                if ($create_dir) new Directory($abs_path, true);

                $filepath = $abs_path.DIRECTORY_SEPARATOR.$key.'.'.Filename::Extension($value['name']);

                if (in_array($filepath, Directory::AllInDirectory($abs_path)))
                {
                    ErrProcessor::MakeError('Error in upload. File with this name exist');
                    return false;
                }

                $upload = move_uploaded_file($value["tmp_name"], $filepath);
                if ($upload) return true;

                ErrProcessor::MakeError('Error in upload. Probably file is invalid.');
                return false;
            }
            else
            {
                ErrProcessor::MakeError('Error in upload. Not valid upload file type.');
                return false;
            }
        }
        return false;
    }
}