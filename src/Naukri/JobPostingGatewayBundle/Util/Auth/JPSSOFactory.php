<?php
namespace Naukri\JobPostingGatewayBundle\Util\Auth;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class JPSSOFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint) { 
    
    
        $providerId = 'security.authentication.provider.jpsso.'.$id;
        $container
        ->setDefinition($providerId, new DefinitionDecorator('jpsso.security.authentication.provider'))
        ->replaceArgument(0, new Reference($userProvider));

        $listenerId = 'security.authentication.listener.jpsso.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('jpsso.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition() { 
    
    
        return 'pre_auth';
    }

    public function getKey() { 
    
    
        return 'jpsso';
    }

    public function addConfiguration(NodeDefinition $node) { 
    
    
    }
}

