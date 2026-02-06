<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\ModuleModel;
use Contao\Template;
use Mstudio\ContaoSimpleCart\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class CheckoutController extends AbstractFrontendModuleController
{
    public const TYPE = 'checkout';

    public function __construct(
        private readonly CartService $cartService,
        private readonly RouterInterface $router
    ) {
    }

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        $template->cart = $this->cartService->getCartItems();

        if ($request->request->has('confirm_purchase')) {
            // Here you would typically save the order to the database,
            // send confirmation emails, and integrate a payment gateway.

            // For now, we just clear the cart.
            $this->cartService->clear();

            $template->confirmed = true;
        }

        return $template->getResponse();
    }
}
