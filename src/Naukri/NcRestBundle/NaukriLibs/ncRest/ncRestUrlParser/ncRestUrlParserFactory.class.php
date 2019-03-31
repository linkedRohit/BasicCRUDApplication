<?php

class ncRestUrlParserFactory
{
    private static $instance ;

    public static function getInstance($ymlPath) {
        if (! isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class($ymlPath);
        }
        return self::$instance;
    }

    private function __construct($ymlPath) {
        $this->config = array();
        $this->config =  ncYaml::load($ymlPath);
        if (!$this->config || count($this->config) == 0) {
            throw new ncRestUrlParserInvalidRequestException(null, 'ncRestUrlParser configuration not found: ' . $ymlPath);
        }
    }

    public function parseUrl($controller) {
        $path = !empty($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (!empty($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
        $path = ltrim($path,'/');
        $arrPathInfo = explode('/',$path);

        $arrMandatoryData = array();
        $count = count($arrPathInfo);
        for ($i=0;$i<$count;$i=$i+2) {
            if ($arrPathInfo[$i]) {
                $arrMandatoryData[$arrPathInfo[$i]] = $arrPathInfo[$i+1];
            }
        }

        if (class_exists('sfContext')) {
            array_shift($arrMandatoryData);
        }

        $urlConfig = $this->config[$controller];
        if (!$urlConfig || count($urlConfig) == 0) {
            throw new ncRestUrlParserInvalidPathException(null, 'ncRestUrlParser configuration not foundfor controller: ' .$controller);
        }

        $objncRestUrlParserManager = new ncRestUrlParserManager(new ncRestUrlParameter());
        return $objncRestUrlParserManager->parseData($urlConfig, $arrMandatoryData);
    }
}

