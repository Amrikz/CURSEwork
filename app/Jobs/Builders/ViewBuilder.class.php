<?php


namespace App\Jobs\Builders;


use App\Lib\File\View;

class ViewBuilder
{
    public static function build($path_arr, $title = null)
    {
        $params =& $GLOBALS['head_params'];
        $params['title'] = $title;

        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks','lib','head.php']));
        View::ViewDir(join(DIRECTORY_SEPARATOR, $path_arr));
        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks', 'lib', 'foot.php']));
    }


    public static function admin_build($path_arr, $title = null)
    {
        $params =& $GLOBALS['head_params'];
        $params['title'] = $title;

        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks','lib','head.php']));
        View::ViewDir(join(DIRECTORY_SEPARATOR, $path_arr));
    }
}