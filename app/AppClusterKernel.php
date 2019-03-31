<?php

require_once('AppKernel.php');

class AppClusterKernel extends AppKernel
{
    public function getCacheDir() {
        $host = $_SERVER['HTTP_HOST'];
        return dirname(__DIR__) . "/app/cache/{$host}/{$this->environment}/";
    }

    
    protected function buildContainer() {
        $container = parent::buildContainer();
        $container->setParameter('CLUSTER_URL', CLUSTER_URL);
        return $container;
    }

}
