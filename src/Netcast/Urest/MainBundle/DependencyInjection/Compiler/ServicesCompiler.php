<?php

namespace Netcast\Urest\MainBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicesCompiler implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container
            ->getDefinition('sonata.user.form.type.security_roles')
            ->setClass('Netcast\Urest\MainBundle\Form\Type\SecurityRolesType');
        $container
            ->getDefinition('sonata.admin.twig.extension')
            ->setClass('Netcast\Urest\MainBundle\Twig\SonataAdminExtension');

        $container->setParameter('twig.form.resources', array_merge(
            $container->getParameter('twig.form.resources'),
            array('::form.html.twig')
        ));
    }
}