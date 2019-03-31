<?php
namespace Naukri\JobPostingGatewayBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailerCompilerPass
 *
 * @author Arpit
 */
class MailerCompilerPass implements CompilerPassInterface
{
    
    public function process(ContainerBuilder $container) 
    {
        if (!$container->hasDefinition('jp.mailer')) {
            return;
        }
        $definition = $container->getDefinition('jp.mailer');
       
        $clientServices = $container->findTaggedServiceIds('jp.mailer.client');
        foreach ($clientServices as $id => $attributes) {
            $definition->addMethodCall('addMailerClient',  array(new Reference($id)));
        }
    }
}

?>
