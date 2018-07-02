<?php

namespace MegaData\MegaDataBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class MegaDataExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator('@MegaDataBundle/Resources/config')
        );
        $loader->load('mega_data.yml');
    }

    public static function getAlias()
    {
        return 'mega_data';
    }
}