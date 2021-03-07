<?php


namespace App\Lib\Format;


use App\Lib\Logging\Status;

class Validator
{
    public $rules;
    public $status;

    public $is_all_required;


    public function __construct($rules = null)
    {
        $status = [
            'status'    => false,
            'message'   => [],
            'required'  => [],
        ];

        $this->status = new Status($status);

        if ($rules) $this->Set($rules);
    }


    public function Set($rules)
    {
        $this->rules = $rules;
        return true;
    }


    public function Validate($params)
    {
        $flag = true;
        $this->is_all_required = true;
        foreach ($this->rules as $id=>$rule)
        {
            $decompressed_rule = explode('|', $rule);
            foreach ($decompressed_rule as $value)
            {
                switch ($value)
                {
                    case 'required':
                        if (!isset($params[$id]) || !$params[$id])
                        {
                            $this->status->AddArrValue('required', $id);
                            $flag = false;
                        }
                        else
                        {
                            $this->is_all_required = false;
                        }
                        break;

                    case 'numeric':
                    case 'integer':
                    case 'int':
                        if ($params[$id])
                        {
                            if (!is_numeric($params[$id]))
                            {
                                $this->status->AddArrValue('message', "'$id' must be int");
                                $flag = false;
                            }
                        }
                        break;
                }
            }
        }
        if ($flag === true)
        {
            $this->status->SetValue('status',true);
            $this->status->SetValue('message','success');
            return true;
        }
        $this->status->SetValue('status',false);
        $this->status->SetValue('response_code',400);
        return false;
    }


    public function Status()
    {
        $status = $this->status->GetArrStatus();
        $this->status->SetValue('required', $status['required']);
        $this->status->SetValue('message', $status['message']);
        return $this->status->GetArrStatus();
    }
}