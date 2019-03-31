<?php

namespace Naukri\JobPostingGatewayBundle;

use Naukri\JobPostingGatewayBundle\DependencyInjection\Compiler\SmartyCompilerPass;
use Naukri\JobPostingGatewayBundle\DependencyInjection\Compiler\MailerCompilerPass;
use Naukri\JobPostingGatewayBundle\Util\Auth\JPSSOFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NaukriJobPostingGatewayBundle extends Bundle
{

    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new SmartyCompilerPass());
        $container->addCompilerPass(new MailerCompilerPass());
        /* Adding custom security listener for SSO Login */
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new JPSSOFactory());
    }

}
