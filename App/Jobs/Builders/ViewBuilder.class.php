<?php


namespace App\Jobs\Builders;


use Bin\Framework\Lib\File\View;

class ViewBuilder
{
    private static function _BuildGate($params_arr = [])
    {
        $params =& $GLOBALS['head_params'];

        foreach ($params_arr as $key=>$value)
            $params[$key] = $value;
    }


    public static function Build($path_arr, $title = null, $params_arr = [])
    {
        $params_arr['title'] = $title;
        self::_BuildGate($params_arr);

        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks','lib','head.php']));
        View::ViewDir(join(DIRECTORY_SEPARATOR, $path_arr));
        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks', 'lib', 'foot.php']));
    }


    public static function AdminBuild($path_arr, $title = null, $params_arr = [])
    {
        $params_arr['title'] = $title;
        self::_BuildGate($params_arr);

        View::ViewDir(join(DIRECTORY_SEPARATOR, ['blocks','lib','head.php']));
        View::ViewDir(join(DIRECTORY_SEPARATOR, $path_arr));
    }
}