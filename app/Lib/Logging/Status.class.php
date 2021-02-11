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


    public function Nullify($complete = false)
    {
        if ($complete) $this->status = null;
        else
        {
            $this->status = array(
                "status"    => null,
                "message"   => null,
                "required"  => null
            );
        }
    }


    public function GetArrStatus()
    {
        return $this->status;
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


    public function SetValue($id, $value)
    {
        $this->status[$id] = $value;
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


    /**
     * Checks every status in $statuses array and return only statuses with [status = false]
     * @param $statuses
     * @return array
     */
    public static function StatusCheck($statuses)
    {
        foreach ($statuses as $key=>$value)
        {
            if ($statuses[$key]['status'] == false) $res[] = $statuses[$key];
        }
        return $res;
    }


    public static function NewError($message)
    {
        $status = new self();
        $status->SetValue('status', false);
        $status->SetValue('message', $message);
        return $status;
    }
}