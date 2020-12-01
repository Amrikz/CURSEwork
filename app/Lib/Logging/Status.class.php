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
        if ($complete) $this->status = array();
        else
        {
            foreach ($this->status as $key => $value)
            {
                $this->status[$key] = null;
            }
        }
    }


    public function Get()
    {
        return $this->status;
    }


    public function AddValue($id, $value)
    {
        $this->status[$id] .= $value;
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


    public function SwitcherFunctionRegister()
    {
        
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
}