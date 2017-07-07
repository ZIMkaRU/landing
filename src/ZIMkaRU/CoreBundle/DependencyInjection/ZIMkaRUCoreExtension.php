<?php

/**
 * Created by PhpStorm.
 * User: voronkov_vs
 * Date: 15.07.2016
 * Time: 9:49
 */

namespace ZIMkaRU\CoreBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class ZIMkaRUCoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // ...
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // ...
        $loader->load('admin.yml');
    }
}