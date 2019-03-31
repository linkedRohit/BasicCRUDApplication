<?php
namespace Naukri\UtilityBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SmartyCompilerPass
 * change the default smarty engine with a custom engine
 *
 * @author prabin
 */
class SmartyCompilerPass implements CompilerPassInterface{
    public function process(ContainerBuilder $container) {
        if (!$container->hasDefinition('templating.engine.smarty')) {
            return;
        }
        $smartyDef = $container->getDefinition('templating.engine.smarty');
        if($smartyDef){
            $smartyDef->setClass("Naukri\UtilityBundle\DependencyInjection\Overrides\NaukriSmartyEngine");
        }
    }
}

?>
