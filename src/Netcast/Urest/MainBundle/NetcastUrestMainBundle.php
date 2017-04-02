<?php

namespace Netcast\Urest\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Netcast\Urest\MainBundle\DependencyInjection\Compiler\ServicesCompiler;

class NetcastUrestMainBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->addCompilerPass(new ServicesCompiler());
    }
}