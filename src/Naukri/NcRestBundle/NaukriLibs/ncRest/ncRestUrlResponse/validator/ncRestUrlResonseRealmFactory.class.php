<?php

class ncRestUrlResonseRealmFactory{

    private static $instance ;

    public static function getInstance() {
        if(! isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }
        return self::$instance;
    }

    private function __construct() {
    }


    public function getRealmClass($realm){
        switch ($realm){
        case 'api.naukri.com' : return new ncRestUrlNaukriApiAuthorizer();
        break;
        default : throw new Exception('Invalid authorization realm: '. $realm);
        }
    }

}

