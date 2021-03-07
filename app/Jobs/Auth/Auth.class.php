<?php


namespace App\Jobs\Auth;


use App\Lib\Random\RandomVars;
use App\Models\Roles;
use App\Models\Users;
use App\Lib\Logging\Status;

class Auth 
{
    public static $status;

    public static $user = null;
    public static $role = null;


    public static function __constructStatic()
    {
        self::Initialize();
    }


    public static function Initialize()
    {
        self::$status = new Status();

        self::$status->SwitcherRegister('0','message','Вы успешно авторизировались!');
        self::$status->SwitcherRegister('0','status',true);

        self::$status->SwitcherRegister('1','message',"Комбинация логин|пароль не найдены");
        self::$status->SwitcherRegister('1','status',false);
        self::$status->SwitcherRegister('1','response_code',400);

        self::$status->SwitcherRegister('2','message',"Пользователь с таким логином уже существует");
        self::$status->SwitcherRegister('2','status',false);
        self::$status->SwitcherRegister('2','response_code',400);

        self::$status->SwitcherRegister('3','message',"Пароли не совпадают");
        self::$status->SwitcherRegister('3','status',false);
        self::$status->SwitcherRegister('3','response_code',400);

        self::$status->SwitcherRegister('4','message',"Успешно зарегистрировано!");
        self::$status->SwitcherRegister('4','status',true);

        self::$status->SwitcherRegister('5','message',"Ошибка при обновлении записи пользователя");
        self::$status->SwitcherRegister('5','status',false);
        self::$status->SwitcherRegister('5','response_code',500);

        self::$status->SwitcherRegister('6','message',"Для этого запроса необходима авторизация");
        self::$status->SwitcherRegister('6','status',false);
        self::$status->SwitcherRegister('6','required',['token']);
        self::$status->SwitcherRegister('6','response_code',400);

        self::$status->SwitcherRegister('7','message',"Владелец данного токена не найден");
        self::$status->SwitcherRegister('7','status',false);
        self::$status->SwitcherRegister('7','response_code',400);

        self::$status->SwitcherRegister('8','message',"У вас недостаточно прав для доступа к этому материалу");
        self::$status->SwitcherRegister('8','status',false);
        self::$status->SwitcherRegister('8','response_code',400);
    }


    public static function GetArrStatus()
    {
        if (!self::$status) self::Initialize();
        return self::$status->GetArrStatus();
    }


    public static function GetJsonStatus()
    {
        if (!self::$status) self::Initialize();
        return self::$status->GetJsonStatus();
    }


    private static function NullifyStatus()
    {
        if (!self::$status) self::Initialize();
        self::$status->Nullify();
    }


    private static function _generateToken($salt = null)
    {
        do
        {
            $token = trim(password_hash(RandomVars::Str(50).$salt, PASSWORD_BCRYPT));
            $check = Users::Select([Users::$id_name],[Users::$token_name => $token]);
        }
        while ($check);

        return $token;
    }


    public static function Login($request)
	{
		self::NullifyStatus();

        $user = Users::FindBy(Users::$login_name, $request['login'])[0];
        $request['password'] = password_verify($request['password'], trim($user['password']));
        if ($request['password'] && $user['id'])
        {
            $role = Roles::GetByID($user[Users::$role_id_name]);

            self::$user = $user;
            self::$role = $role;

            $token = self::_generateToken($request['login']);
            if (Users::UpdateByID($user['id'], [Users::$token_name => $token]))
            {
                self::$status->StatusSwitch(0);

                self::$status->status['data']['token'] = $token;
                self::$status->status['data']['role']  = $role['name'];

                return true;
            }
            self::$status->StatusSwitch(5);
            return false;
        }
        else
        {
            self::$status->StatusSwitch(1);
            return false;
        }
    }


    public static function Register($request)
    {
        self::NullifyStatus();

        if ($request['password'] == $request['c_password'])
        {
            $user = Users::FindBy(Users::$login_name, $request['login'])[0];
            if ($user['id'])
            {
                self::$status->StatusSwitch(2);
                return false;
            }

            $request['password']    = trim(password_hash($request['password'], PASSWORD_BCRYPT));
            $request['token']       = self::_generateToken($request['login']);

            if (Users::RegisterInsert($request) == 1)
            {
                self::$status->StatusSwitch(4);
                self::$status->SetValue('token', $request['token']);

                return true;
            }
            return false;
        }
        else
        {
            self::$status->StatusSwitch(3);
            return false;
        }
	}


	public static function TokenCheck($token, $roles)
    {
        if (!isset($token) || !$token)
        {
            self::$status->StatusSwitch(6);
            return false;
        }

        $user = Users::FindBy(Users::$token_name, $token)[0];
        if (!$user)
        {
            self::$status->StatusSwitch(7);
            return false;
        }
        $user_role = Roles::GetByID($user['role_id']);

        if (!in_array('*', $roles) && !in_array($user_role, $roles))
        {
            self::$status->StatusSwitch(8);
            return false;
        }

        self::$user = $user;
        self::$role = $user_role;
        return true;
    }
}