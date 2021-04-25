<?php


namespace App\Models;


use App\Jobs\Auth\Auth;
use Bin\Framework\Lib\Middleware\Repository;
use Config\AppConfig;

abstract class BaseModel implements ModelInterface
{
    public static $table_name       = '';

    public static $id_name          = 'id';

    public static $fillable_fields  = [];


    protected static function params_init()
    {
        $vars = get_class_vars(static::class);
        foreach ($vars as $key=>$var)
        {
            if (!$var && strpos($key,'_name'))
            {
                static::$$key = substr_replace($key,'',-5);
            }
        }
        self::fillable_init();
    }


    protected static function fillable_init($arr = null, $complete = false)
    {
        if (!$arr || $complete)
            static::$fillable_fields = null;
        elseif ($arr == '*')
        {
            $vars = get_class_vars(static::class);
            foreach ($vars as $key=>$var)
            {
                if (strpos($key,'_name') && !in_array($key,AppConfig::FILLABLE_BLACKLIST))
                {
                    static::$fillable_fields[] = str_replace('_name', '', $key);
                }
            }
        }
        else
            foreach ($arr as $key=>$value)
            {
                if (!is_array($value) || in_array(Auth::$role, explode(',', $key)))
                    static::$fillable_fields[] = $value;
            }
    }


    protected static function fillable_exclude($arr)
    {
        foreach ($arr as $value)
        {
            $fillable =& static::$fillable_fields;
            if (in_array($value, $fillable))
                unset($fillable[array_search($value, $fillable)]);
            elseif (in_array($value.'_name', $fillable))
                unset($fillable[array_search($value.'_name', $fillable)]);
        }
    }


    private static function _params_for_edit($arr = null)
    {
        $what = null;

        foreach (static::$fillable_fields as $field)
        {
            if (isset($arr[$field])) $what[$field] = $arr[$field];
        }

        return $what;
    }


    public static function Select($what, $where = null, $params = null)
    {
        return Repository::Select($what, static::$table_name, $where, $params);
    }

    public static function Insert($what, $params = null)
    {
        return Repository::Insert($what, static::$table_name, $params);
    }

    public static function Update($what, $where = null, $params = null)
    {
        return Repository::Update($what, static::$table_name, $where, $params);
    }

    public static function Delete($where, $params = null)
    {
        return Repository::Delete(static::$table_name, $where, $params);
    }


    public static function Count($where = null)
    {
        return static::Select('COUNT(*)', $where)[0]['COUNT(*)'];
    }


    public static function FindBy($param, $value, $params = null)
    {
        $param .= "_name";
        $where = [
            static::$$param => $value
        ];

        return self::Select('*', $where, $params);
    }


    public static function GetAll($params = null)
    {
        return self::Select('*', null, $params);
    }


    public static function GetByID($id)
    {
        $where = [
            static::$id_name => $id
        ];

        return self::Select('*', $where)[0];
    }


    public static function Put($arr)
    {
        $what = self::_params_for_edit($arr);

        return self::Insert($what);
    }


    public static function UpdateByID($id, $arr)
    {
        $what = self::_params_for_edit($arr);

        $where = [
            static::$id_name => $id
        ];

        return self::Update($what, $where);
    }


    public static function DeleteByID($id)
    {
        $where = [
            static::$id_name => $id
        ];

        return self::Delete($where);
    }


    public static function Paginated($request, $params = null)
    {
        if (!$request['per_page'])  $request['per_page']    = 1;
        if (!$request['page'])      $request['page']        = 1;

        $count = static::Count();
        $pages = ceil($count / $request['per_page']);
        if ($request['page'] > $pages)
        {
            if ($pages > 0)
                $request['page'] = $pages;
            else
                $request['page'] = 1;
        }

        $from = ($request['page'] - 1) * $request['per_page'];
        $res['items'] = static::GetAll($params." LIMIT $from,$request[per_page]");

        $res['count']          = $count;
        $res['pages']          = $pages;
        $res['current_page']   = $request['page'];
        $res['per_page']       = $request['per_page'];

        return $res;
    }
}