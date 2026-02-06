<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Mstudio\ContaoSimpleCart\Service\CartService;

class MstudioContaoSimpleCartBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/Resources/config'));
        $loader->load('services.yaml');
    }
}
