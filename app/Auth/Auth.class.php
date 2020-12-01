<?php


namespace App\Auth;


use App\Models\UserModel;
use App\Lib\Database\DB;
use App\Lib\Logging\Status;

class Auth
{
    public $status;

    public $table_name;
    public $id_name;
    public $login_name;
    public $password_name;
    public $role_name;


    public function __construct()
    {
        $this->status = new Status([
            "status"    => null,
            "message"   => null,
            "required"  => null
        ]);

        $this->table_name       = UserModel::$table_name;
        $this->id_name          = UserModel::$id_name;
        $this->login_name       = UserModel::$login_name;
        $this->password_name    = UserModel::$password_name;
        $this->role_name        = UserModel::$role_name;

        $this->status->SwitcherRegister('0','message','Вы успешно авторизировались!');
        $this->status->SwitcherRegister('0','status',true);

        $this->status->SwitcherRegister('1','message',"Комбинация логин|пароль не найдены");
        $this->status->SwitcherRegister('1','status',false);

        //$this->status->SwitcherFunctionRegister('1', $this->status->AddValue());

    }


    private function NullifyStatus()
    {
        $this->status->Nullify();
    }


	public function Login($login,$password)
	{
		$this->NullifyStatus();

		if ($login && $password)
		{
            $conn = Db::getConn();
            //$login = trim($login, '+-()"[]/');
            $stmt = $conn->conn->stmt_init();
            if ($stmt->prepare("SELECT $this->id_name,$this->login_name,$this->password_name,$this->role_name FROM $this->table_name  WHERE $this->login_name = ? LIMIT 1"))
            {
                $stmt->bind_param('s', $login);
                $stmt->execute();
                $stmt->bind_result($id, $login, $hash, $role);
                $stmt->fetch();
                $stmt->close();
                $password = password_verify($password, $hash);
                if ($password && $id)
                {
                    $this->status->StatusSwitch(0);

                    $user = array([
                        'id'    => $id,
                        'login' => $login,
                        'role'  => $role
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
                $error                      = $conn->conn->error;
                $this->status->status['status']     = false;
                $this->status->status['message']    = "query error! Error: $error";
                return false;
            }
        }
		else
        {
            if (!$login)    $this->status->AddValue("required",'Введите логин');
            if (!$password) $this->status->AddValue("required",' Введите пароль');
            $this->status->SetValue("status",false);

            return false;
        }
    }


    public static function Register($login, $password, $confirm_password)
    {
        self::$status = array('message' => '');

        if ($login && $password && $confirm_password) {
            if ($password == $confirm_password) {
                $conn = Db::getConn();
                $login = trim($login, '+-()"[]/');
                $stmt = $conn->conn->stmt_init();
                if ($stmt->prepare("SELECT id FROM l_users WHERE login = ? LIMIT 1 ")) {
                    $stmt->bind_param('s', $login);
                    $stmt->execute();
                    $stmt->bind_result($id);
                    $stmt->fetch();
                    if ($id) {
                        self::$status['message'] = "Пользователь с таким именем уже существует";
                        return false;
                    }
                    $stmt->close();
                } else {
                    $error = $conn->conn->error;
                    self::$status['message'] = "query error! Error: $error";
                    return false;
                }
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 7]);

                $stmt = $conn->conn->stmt_init();

                if ($stmt->prepare("INSERT INTO `l_users` (`id`, `login`, `password`) VALUES (NULL, '$login', '$password')")) {
                    $stmt->execute();
                    if ($stmt->affected_rows == 1) {
                        self::$status['message'] = "Успешно зарегистрировано!";
                        $_SESSION['user']['id'] = $id;
                        $_SESSION['user']['login'] = $login;
                        $_SESSION['user']['role'] = 1;
                        return true;
                    } else {
                        $error = $stmt->error;
                        self::$status['message'] = "Unknown column(s) to create. Error: $error";
                        return false;
                    }
                } else {
                    $error = $conn->conn->error;
                    self::$status['message'] = "query error! Error: $error";
                    return false;
                }
            } else {
                self::$status['message'] = "Пароли не совпадают";
                return false;
            }
		}
		else {
            if (!$login) {
                self::$status['message'] = self::$status['message'] . " Введите логин";
            }
            if (!$password) {
                self::$status['message'] = self::$status['message'] . " Введите пароль";
            }
            if (!$confirm_password) {
                self::$status['message'] = self::$status['message'] . " Введите подтверждение пароля";
            }
            return false;
        }
	}

}