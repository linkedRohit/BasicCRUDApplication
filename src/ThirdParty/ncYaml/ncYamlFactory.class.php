<?php

/** class ncYamlFactory
 *
 */
class ncYamlFactory
{
    private $cacher;
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $class = __CLASS__;
            self::$instance = new $class();
        }

        return self::$instance;
    }

    private function __construct() {

    }

    public function getCacher() {
        if (is_null($this->cacher)) {

            if ($this->checkForXCache()) {
                $this->cacher = new ncXCache();
            }
            elseif ($this->checkForApcCache()) {
                $this->cacher = new ncApcCache();
            }
            else {
                $cacheDir = defined('YAML_CACHE_DIR') ? constant('YAML_CACHE_DIR') : '/tmp/yaml_cache';
                $this->cacher = new ncFileCache($cacheDir);
            }
        }

        return $this->cacher;
    }

    private function checkForXCache() {
        return (function_exists('xcache_set') && ini_get('xcache.var_size') > 0);
    }

    private function checkForApcCache() {
        return function_exists('apc_store') && function_exists('apc_exists');
    }
}

