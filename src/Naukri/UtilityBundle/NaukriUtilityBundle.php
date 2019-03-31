<?php

namespace Naukri\UtilityBundle;

use Naukri\UtilityBundle\DependencyInjection\Compiler\SmartyCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NaukriUtilityBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);

        $container->addCompilerPass(new SmartyCompilerPass());
    }
}
