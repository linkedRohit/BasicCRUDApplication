<?php

class ncRestUrlParserValidator
{
    public function validateRequest($objncRestUrlParameter){
        $className = $objncRestUrlParameter->getClassName();
        $methodName = $objncRestUrlParameter->getMethodName();
        $this->validateClassName($className);
        $this->validateMethodName($className, $methodName);
    }

    private function validateClassName($className) {
        $className = trim($className);

        if ($className && class_exists($className)) {
            return true;
        }

        throw new ncRestUrlParserMethodNotAllowedException(null, 'method not allowed');
    }

    private function validateMethodName($className, $methodName) {
        if ($methodName && method_exists($className, $methodName)) {
            return true;
        }

        throw new ncRestUrlParserMethodNotAllowedException(null, 'method not allowed');
    }
}

