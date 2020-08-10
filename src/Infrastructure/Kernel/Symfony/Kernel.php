<?php

namespace Infrastructure\Kernel\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $confDir = $this->getProjectDir();

        $container->import($confDir.'/config/{packages}/*.yaml');
        $container->import($confDir.'/config/{packages}/'.$this->environment.'/*.yaml');

        $container->import($confDir.'/config/{services}.yaml');
        $container->import($confDir.'/config/{services}_'.$this->environment.'.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getProjectDir();

        $routes->import($confDir.'/config/{routes}/'.$this->environment.'/*.yaml');
        $routes->import($confDir.'/config/{routes}/*.yaml');

        $routes->import($confDir.'/config/{routes}.yaml');
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__).'/../../..';
    }
}
