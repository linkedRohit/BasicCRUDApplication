<?php
namespace Naukri\UtilityBundle\DependencyInjection\Overrides;

use Exception;
use NoiseLabs\Bundle\SmartyBundle\SmartyEngine;
use Smarty;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NaukriSmartyEngine
 * This class is introduced to override the default engine available with the smarty bundle. 
 * It is necessiated to register PHP classes which are required in the templates.
 * 
 * The method "enrichSmartyHandle" uses the class definitions specified in the parameters.yml
 * under smarty.overrides to register the classes
 *
 * @author prabin
 */
class NaukriSmartyEngine extends SmartyEngine{
    
    public function __construct(Smarty $smarty, ContainerInterface $container,
    TemplateNameParserInterface $parser, LoaderInterface $loader, array $options,
    GlobalVariables $globals = null, LoggerInterface $logger = null){
        $this->enrichSmartyHandle($smarty, $container);
        parent::__construct($smarty, $container, $parser, $loader, $options, $globals, $logger);
        $this->setCustomGlobalVariables($container);
    }
    
    private function setCustomGlobalVariables(ContainerInterface $container){
        //register some global variables
    }

    private function enrichSmartyHandle(Smarty $smarty, ContainerInterface $container)
    {
        try
        {
            $classes = $container->getParameter("smarty.overrides");
            foreach ($classes["register.classes"] as $name=>$path)
            {
                try
                {
                    $smarty->registerClass($name, $path);
                }
                catch (Exception $e){
                    //$container->get("sm.logger")->getLogger()->err("error while registering php class to smarty ". $e->getMessage());
                }
            }
        }
        catch (Exception $e){
            //$container->get("sm.logger")->getLogger()->err("error while registering php class to smarty ". $e->getMessage());
        }
    }
}

?>
