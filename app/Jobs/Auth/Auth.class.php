<?php


namespace App\Jobs\Auth;


use App\Models\Users;
use App\Lib\Logging\Status;

class Auth 
{
    public static $status;


    public static function Initialize()
    {
        self::$status = new Status([
            "status"    => null,
            "message"   => null,
            "required"  => null
        ]);

        self::$status->SwitcherRegister('-1', 'message', '');
        self::$status->SwitcherRegister('-1', 'status', false);


        self::$status->SwitcherRegister('0','message','Вы успешно авторизировались!');
        self::$status->SwitcherRegister('0','status',true);

        self::$status->SwitcherRegister('1','message',"Комбинация логин|пароль не найдены");
        self::$status->SwitcherRegister('1','status',false);

        self::$status->SwitcherRegister('2','message',"Пользователь с таким именем уже существует");
        self::$status->SwitcherRegister('2','status',false);

        self::$status->SwitcherRegister('3','message',"Пароли не совпадают");
        self::$status->SwitcherRegister('3','status',false);

        self::$status->SwitcherRegister('4','message',"Успешно зарегистрировано!");
        self::$status->SwitcherRegister('4','status',true);
    }


    private static function NullifyStatus()
    {
        if (!self::$status) self::Initialize();
        self::$status->Nullify();
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


    public static function Login($login,$password)
	{
		self::NullifyStatus();

		if ($login && $password)
		{
		    $user = Users::FindBy(Users::$login_name, $login)[0];
            $password = password_verify($password, trim($user['password']));
            if ($password && $user['id'])
            {
                self::$status->StatusSwitch(0);

                $user = array(
                    'id'        => $user['id'],
                    'login'     => $user['login'],
                    'role_id'   => $user['role_id']
                );
                $_SESSION['user'] = $user;
                return true;
            }
            else
            {
                self::$status->StatusSwitch(1);
                return false;
            }
        }
		else
        {
            if (!$login)    self::$status->AddValue("required",'Введите логин');
            if (!$password) self::$status->AddValue("required",'Введите пароль');
            self::$status->SetValue("status",false);

            return false;
        }
    }


    public static function Register($login, $password, $confirm_password, $stateless = false)
    {
        self::NullifyStatus();

        if ($login && $password && $confirm_password)
        {
            if ($password == $confirm_password)
            {
                $user = Users::FindBy(Users::$login_name, $login)[0];
                if ($user['id'])
                {
                    self::$status->StatusSwitch(2);
                    return false;
                }

                $password = trim(password_hash($password, PASSWORD_BCRYPT));

                if (Users::RegisterInsert($login, $password) == 1)
                {
                    self::$status->StatusSwitch(4);

                    if (!$stateless)
                    {
                        $db_user = Users::FindBy(Users::$login_name, $login)[0];
                        $user = array(
                            'id'        => $db_user['id'],
                            'login'     => $db_user['login'],
                            'role_id'   => $db_user['role_id']
                        );
                        $_SESSION['user'] = $user;
                    }
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
		else
        {
            if (!$login)            self::$status->AddValue("required",'Введите логин');
            if (!$password)         self::$status->AddValue("required",'Введите пароль');
            if (!$confirm_password) self::$status->AddValue("required",'Введите подтверждение пароля');
            self::$status->SetValue("status",false);
            return false;
        }
	}
}