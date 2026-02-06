<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Mstudio\ContaoSimpleCart\MstudioContaoSimpleCartBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(MstudioContaoSimpleCartBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
