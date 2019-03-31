<?php
namespace Naukri\JobPostingGatewayBundle\Resources\model;

//use Naukri\JobPostingGatewayBundle\Util\Common\CommonUtil;

abstract class BaseModel
{
    
    public function getObjectToArrayNotNullKeys() { 
    
        //return CommonUtil::getObjectAsArrayWithoutNull($this);
    }

    public function getArrayToObject($array) { 
    
        foreach ($array as $key => $val) {
            if (property_exists($this, $key)) {
                $methodName = 'set'.ucfirst($key);
                if (method_exists($this, $methodName)) {
                    call_user_func(array($this, $methodName), array($val));
                } else {
                    $this->$key=$val;
                }
            } else {
                $this->$key=$val;
            }
        }
        return $this;
    }
}

