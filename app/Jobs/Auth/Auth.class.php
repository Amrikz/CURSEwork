<?php


namespace App\Jobs\Auth;


use App\Lib\Logging\StatusInterface;
use App\Models\Users;
use App\Lib\Logging\Status;

class Auth implements StatusInterface
{
    public $status;


    public function __construct()
    {
        $this->status = new Status([
            "status"    => null,
            "message"   => null,
            "required"  => null
        ]);

        $this->status->SwitcherRegister('-1', 'message', '');
        $this->status->SwitcherRegister('-1', 'status', false);


        $this->status->SwitcherRegister('0','message','Вы успешно авторизировались!');
        $this->status->SwitcherRegister('0','status',true);

        $this->status->SwitcherRegister('1','message',"Комбинация логин|пароль не найдены");
        $this->status->SwitcherRegister('1','status',false);

        $this->status->SwitcherRegister('2','message',"Пользователь с таким именем уже существует");
        $this->status->SwitcherRegister('2','status',false);

        $this->status->SwitcherRegister('3','message',"Пароли не совпадают");
        $this->status->SwitcherRegister('3','status',false);

        $this->status->SwitcherRegister('4','message',"Успешно зарегистрировано!");
        $this->status->SwitcherRegister('4','status',true);
    }


    private function NullifyStatus()
    {
        $this->status->Nullify();
    }


    public function GetArrStatus()
    {
        return $this->status->GetArrStatus();
    }


    public function GetJsonStatus()
    {
        return $this->status->GetJsonStatus();
    }


    public function Login($login,$password)
	{
		$this->NullifyStatus();

		if ($login && $password)
		{
		    $user = Users::GetByLogin($login);
            $password = password_verify($password, $user['password']);
            if ($password && $user['id'])
            {
                $this->status->StatusSwitch(0);

                $user = array([
                    'id'    => $user['id'],
                    'login' => $user['login'],
                    'role'  => $user['role']
                ]);
                return $user;
            }
            else
            {
                $this->status->StatusSwitch(1);
                return false;
            }
        }
		else
        {
            if (!$login)    $this->status->AddValue("required",'Введите логин');
            if (!$password) $this->status->AddValue("required",'Введите пароль');
            $this->status->SetValue("status",false);

            return false;
        }
    }


    public function Register($login, $password, $confirm_password)
    {
        $this->NullifyStatus();

        if ($login && $password && $confirm_password)
        {
            if ($password == $confirm_password)
            {
                $user = Users::GetByLogin($login);
                if ($user['id'])
                {
                    $this->status->StatusSwitch(2);
                    return false;
                }

                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 7]);

                if (Users::RegisterInsert($login, $password) == 1)
                {
                    $this->status->StatusSwitch(4);
                    $_SESSION['user']['id']     = $user['id'];
                    $_SESSION['user']['login']  = $user['login'];
                    $_SESSION['user']['role']   = $user['role'];
                    return true;
                }
                return false;
            }
            else
            {
                $this->status->StatusSwitch(3);
                return false;
            }
		}
		else
        {
            if (!$login)            $this->status->AddValue("required",'Введите логин');
            if (!$password)         $this->status->AddValue("required",'Введите пароль');
            if (!$confirm_password) $this->status->AddValue("required",'Введите подтверждение пароля');
            $this->status->SetValue("status",false);
            return false;
        }
	}
}