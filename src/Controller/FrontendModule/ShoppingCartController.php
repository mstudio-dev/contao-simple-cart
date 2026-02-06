<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mstudio\ContaoSimpleCart\Model\ProductModel;

class ShoppingCartController extends AbstractFrontendModuleController
{
    public const TYPE = 'shopping_cart';

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        $products = ProductModel::findAll();
        $template->products = $products;

        return $template->getResponse();
    }
}
