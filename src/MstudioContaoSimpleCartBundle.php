<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MstudioContaoSimpleCartBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
