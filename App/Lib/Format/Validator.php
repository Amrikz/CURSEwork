<?php


namespace App\Lib\Format;


use App\Lib\Logging\Status;

class Validator
{
    public $rules;
    public $status;
    public $flag;

    public $is_all_required;

    private $container;


    public function __construct($rules = null)
    {
        $status = [
            'status'    => false,
            'message'   => [],
        ];

        $this->status = new Status($status);
        $this->container =& $this->status->validator;

        if ($rules) $this->Set($rules);
    }


    public function Set($rules)
    {
        $this->rules = $rules;
        return true;
    }


    public function Message($message)
    {
        $this->status->SetValue('message', $message);
    }


    private function _processParams($rule_key, $decompressed_rule, &$params, $container)
    {
        foreach ($decompressed_rule as $value)
        {
            $parsed_rule = explode(':', $value);

            if (isset($parsed_rule[1]))
            {
                $rule = $parsed_rule[0];
                $param = $parsed_rule[1];
            }
            else
                $rule = $parsed_rule[0];

            $item =& $params[$rule_key];

            switch ($rule)
            {
                case 'required':
                    if (!isset($item))
                    {
                        $container->AddValue($rule_key,'required');
                        $this->flag = false;
                    }
                    else
                    {
                        $this->is_all_required = false;
                    }
                    break;

                case 'numeric':
                case 'integer':
                case 'int':
                    if (isset($item))
                    {
                        if (!is_numeric($item))
                        {
                            $container->AddValue($rule_key,'Must be type of integer (numeric)');
                            $this->flag = false;
                        }
                        else
                            $item = (double) $item;
                    }
                    break;

                case 'min':
                    if (isset($item))
                    {
                        if ($item < $param)
                        {
                            $container->AddValue($rule_key,"Must be $param or higher");
                            $this->flag = false;
                        }
                    }
                    break;

                case 'max':
                    if (isset($item))
                    {
                        if ($item > $param)
                        {
                            $container->AddValue($rule_key,"Must be $param or lower");
                            $this->flag = false;
                        }
                    }
                    break;

                case 'arr':
                    if (isset($item))
                    {
                        if (!is_array($item))
                        {
                            $container->AddValue($rule_key,"Must be type of array");
                            $this->flag = false;
                        }
                    }
                    break;
            }
        }
    }


    private function _subRuleProcessor($params, &$container, $sub_rule, $each = false)
    {
        if (!isset($container->status) && !isset($params) && $sub_rule == 'required')
        {
            if ($each) $container->AddValue(0, new Status(['required']));
            else $container->SetStatus('required');
            $this->flag = false;
        }
    }


    private function _process($rules, &$params, &$container = null)
    {
        if (!$container)
            $container =& $this->container;

        foreach ($rules as $id=>$rule)
        {
            if (is_array($rule))
            {
                $decompressed_id = explode('|', $id);
                if ($decompressed_id[1])
                {
                    $id = $decompressed_id[0];
                    $sub_rule = $decompressed_id[1];
                }

                if ($id == 'each')
                {
                    for ($count = 0;$count < count($params);$count++)
                        $this->_process($rule, $params[$count], $container->$count);
                    $this->_subRuleProcessor($params,$container, $sub_rule, true);

                    foreach ($container->status as $key=>$status)
                    {
                        if (!$status->status) unset($container->status[$key]);
                    }
                }
                else
                {
                    $this->_process($rule, $params[$id], $container->$id);
                    $this->_subRuleProcessor($params[$id],$container->$id, $sub_rule);
                }
            }
            else
            {
                $decompressed_rule = explode('|', $rule);
                $this->_processParams($id, $decompressed_rule, $params, $container);
            }
        }
    }


    public function Validate(&$params)
    {
        $this->flag = true;
        $this->is_all_required = true;

        $this->_process($this->rules, $params);

        if ($this->flag === true)
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
        foreach ($status['validator'] as $key=>$value)
        {
            if (!$value) $this->status->validator->UnsetValue($key);
        }

        $this->status->SetValue('message', $status['message']);
        return $this->status->GetArrStatus();
    }
}