<?php


namespace App\Jobs\Builders;


use App\Lib\File\View;

class ViewBuilder
{
    private static function _BuildGate($title = null)
    {
        $params =& $GLOBALS['head_params'];
        $params['title'] = $title;
    }


    public static function Build($path_arr, $title = null)
    {
        self::_BuildGate($title);

        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks','index','header.php']));
        View::ViewDir(join(DIRECTORY_SEPARATOR, $path_arr));
        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks', 'index', 'foot.php']));
    }


    public static function AdminBuild($path_arr, $title = null)
    {
        self::_BuildGate($title);

        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks','lib','head.php']));
        View::ViewDir(join(DIRECTORY_SEPARATOR, $path_arr));
    }
}