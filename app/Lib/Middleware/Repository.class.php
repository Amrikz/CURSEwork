<?php


namespace App\Lib\Middleware;


use App\Lib\Database\DBInterface;
use App\Lib\Database\SqlsrvDB;
use Config\AppConfig;

class Repository
{
    private static $connection;
    private static $db_class;

    private static $params;
    private static $statement = AppConfig::REPOSITORY_STATEMENT_MODE;

    /**
     * @param $sql
     * @param null|array $params
     * @return mixed
     */
    public static function Raw($sql, $params = null)
    {
        self::$params = $params;
        return self::QueryBasis($sql);
    }


    public static function Select($what, $table, $where = null, $params = null)
    {
        return self::QueryPerformer("SELECT", $what, $table, $where, $params);
    }


    public static function Update($what, $table, $where = null, $params = null)
    {
        return self::QueryPerformer("UPDATE", $what, $table, $where, $params);
    }


    public static function Insert($what, $table, $params = null)
    {
        return self::QueryPerformer("INSERT", $what, $table, null, $params);
    }


    public static function Delete($table, $where, $params = null)
    {
        return self::QueryPerformer("DELETE", null, $table, $where, $params);
    }


    public static function Initialize($db_class)
    {
        if (!((new $db_class) instanceof DBInterface)) makeError("Class $db_class is not instance of DBInterface");

        self::$db_class = new $db_class;
        return self::GetConn();
    }


    private static function QueryBasis($sql)
    {
        self::GetConn();
        $db =& self::$db_class;
        if (self::$statement)
        {
            $db->StmtPrepare($sql);
            $db->StmtExecute(self::$params);
        }
        else $db->Query($sql);
        $res = $db->Fetch();
        if (!$res) $res = $db->AffectedRows();
        self::$params = null;
        return $res;
    }


    private static function QueryPerformer($operation, $what, $table, $where = null, $params = null)
    {
        return self::QueryBasis(self::SqlBuilder($operation, $what, $table, $where, $params));
    }


    private static function GetConn()
    {
        if (!self::$db_class) self::Initialize(AppConfig::REPOSITORY_DB_CLASS);
        if (is_null(self::$connection))
        {
            self::$connection = self::$db_class::GetConn();
        }
        return self::$connection;
    }


    private static function SqlBuilder($operation, $what, $table, $where = null, $params = null, $where_delimiter = 'AND', $params_delimiter = 'AND')
    {
        switch ($operation)
        {
            case "DELETE":
                return join(' ', [
                    $operation,
                    "FROM $table",
                    self::WhereWrapper(self::ParamAdapter($where, 'all', " $where_delimiter ")),
                    self::ParamAdapter($params, 'all', " $params_delimiter ")
                ]);

            case "UPDATE":
            return join(' ', [
                $operation,
                "$table",
                "SET",
                self::ParamAdapter($what),
                self::WhereWrapper(self::ParamAdapter($where, 'all', " $where_delimiter ")),
                self::ParamAdapter($params, 'all', " $params_delimiter ")
            ]);

            case "SELECT":
                return join(' ', [
                    $operation,
                    self::SqlsrvParamAdapter($what,'data'),
                    "FROM $table",
                    self::WhereWrapper(self::ParamAdapter($where, 'all', " $where_delimiter ")),
                    self::ParamAdapter($params, 'all', " $params_delimiter ")
                ]);

            case "INSERT":
                return join(' ', [
                    $operation." INTO",
                    "$table",
                    '('.self::ParamAdapter($what, 'keys').')',
                    'VALUES',
                    '('.self::ParamAdapter($what, 'stmt_data').')',
                    self::ParamAdapter($params, 'all', " $params_delimiter ")
                ]);

            default:
                return false;
        }
    }


    private static function ParamAdapter($param , $mode = 'all', $delimiter = ',')
    {
        if (is_null($param)) return null;
        if (is_string($param)) return $param;

        if (self::$statement) return self::StatementParamAdapter($param, $mode, $delimiter);

        switch ($mode)
        {
            case 'data':
                $res = arrayDataToStr($param, $delimiter);
                return $res;
            case 'keys':
                $res = arrayKeysToStr($param, $delimiter);
                return $res;
            case 'all':
                $res = arrayToStr($param, $delimiter);
                return $res;
        }
        return false;
    }


    private static function StatementParamAdapter($param, $mode, $delimiter)
    {
        $res = null;

        foreach ($param as $key=>$value)
        {
            switch ($mode)
            {
                case 'sqlsrv_data':
                    if (is_null($value))
                    {
                        $value = 'NULL';
                        $res .= $value.$delimiter;
                        break;
                    }
                    $res .= "[$value]$delimiter";
                    break;

                case 'data':
                    if (is_null($value))
                    {
                        $value = 'NULL';
                        $res .= $value.$delimiter;
                        break;
                    }
                    $res .= "'$value'$delimiter";
                    break;
                case 'stmt_data':
                    if (is_null($value))
                    {
                        $value = 'NULL';
                        $res .= $value.$delimiter;
                        break;
                    }
                    self::$params[] = $value;
                    $res .= "?$delimiter";
                    break;
                case 'keys':
                    $res .= $key.$delimiter;
                    break;
                case 'all':
                    self::$params[] = $value;
                    $res .= "$key = ?$delimiter";
                    break;
            }
        }
        $res = trim($res, $delimiter);
        return $res;
    }


    private static function WhereWrapper($res)
    {
        if (!is_null($res)) $res = "WHERE $res";
        return $res;
    }


    private static function SqlsrvParamAdapter($param, $mode = 'all')
    {
        if (AppConfig::REPOSITORY_DB_CLASS == SqlsrvDB::class) return self::ParamAdapter($param, 'sqlsrv_'.$mode);
        return self::ParamAdapter($param, 'data');
    }
}