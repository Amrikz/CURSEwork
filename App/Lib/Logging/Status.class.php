<?php


namespace App\Lib\Logging;


class Status
{
    public $status;

    private $_switcher = [];


    public function __construct($status = null)
    {
        if (is_null($status)) $this->Nullify(true);
        else $this->status = $status;

        return $this->status;
    }


    public function __get($name)
    {
        if (!isset($this->status[$name])) $this->status[$name] = new Status;
        return $this->status[$name];
    }


    public function Nullify($complete = false)
    {
        if ($complete) $this->status = null;
        else
        {
            $this->status = array(
                "status"            => null,
                "message"           => null,
                "required"          => null,
                "response_code"     => 200
            );
        }
    }


    private function _UnwrapStatus($status)
    {
        foreach ($status as $key=>$value)
        {
            if ($value instanceof $this)
            {
                $status[$key] = $this->_UnwrapStatus($value->status);
            }
        }
        return $status;
    }


    public function GetArrStatus()
    {
        return $this->_UnwrapStatus($this->status);
    }


    public function GetJsonStatus()
    {
        return json_encode(self::GetArrStatus());
    }


    public function AddValue($id, $value, $delimiter = ',')
    {
        if ($this->status[$id]) $this->status[$id] .= $delimiter.$value;
        $this->status[$id] = $value;
    }


    public function AddArrValue($id, $value)
    {
        $this->status[$id][] = $value;
    }


    public function SetStatus($status)
    {
        $this->status = $status;
    }


    public function SetValue($id, ...$value)
    {
        if (!isset($value)) $this->status[] = $id;
        else $this->status[$id] = $value[0];
    }


    public function UnsetValue($id)
    {
        unset($this->status[$id]);
    }


    public function SwitcherRegister($status, $idAffectsFor, $howAffects)
    {
        //Repeat cutter
        foreach ($this->_switcher as $switch)
            if ($switch["status"]       == $status &&
                $switch["idAffectsFor"] == $idAffectsFor) return true;

        //Adding switch
        $this->_switcher[] = [
            "status"        => $status,
            "idAffectsFor"  => $idAffectsFor,
            "howAffects"    => $howAffects
        ];

        //Bool output
        foreach ($this->_switcher as $switch)
            if ($switch["status"]       == $status &&
                $switch["idAffectsFor"] == $idAffectsFor) return true;
        return false;
    }


    public function SwitcherUnregister($status)
    {
        $ok = false;
        foreach ($this->_switcher as $key => $switch)
            if ($switch["status"] == $status)
            {
                $ok = true;
                unset($this->_switcher[$key]);
            }
        if ($ok == true) return true;
        return false;
    }


    public function StatusSwitch($status)
    {
        $ok = false;
        foreach ($this->_switcher as $switch)
            if ($switch["status"] == $status)
            {
                $ok = true;
                $this->status[$switch["idAffectsFor"]] = $switch["howAffects"];
            }
        if ($ok == true) return true;
        return false;
    }


    public static function NewError($message, $data = null)
    {
        $status = new self();
        $status->SetValue('status', false);
        $status->SetValue('message', $message);
        if (isset($data)) $status->SetValue('data', $data);
        return $status;
    }


    public static function NewResponse($message, $data = null)
    {
        $status = new self();
        $status->SetValue('status', true);
        $status->SetValue('message', $message);
        if (isset($data)) $status->SetValue('data', $data);
        return $status;
    }
}