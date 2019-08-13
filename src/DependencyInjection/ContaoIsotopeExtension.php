<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class ContaoIsotopeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        static $files = [
            'config.yml',
            'services.yml',
        ];

        foreach ($files as $file) {
            $loader->load($file);
        }

        // Adjust VrPaymentManager to use logger if is defined
        $paymentManagerDefinition = $container->getDefinition('Vrpayment\ContaoIsotopeBundle\VrPaymentManager')->setMethodCalls();

        foreach ($mergedConfig as $config) {
            if ($config['logger']) {
                $paymentManagerDefinition->addMethodCall('setLogger', [new Reference($config['logger'])]);
            }
        }
    }
}
