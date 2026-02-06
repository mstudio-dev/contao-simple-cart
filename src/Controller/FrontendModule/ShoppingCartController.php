<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\Controller\FrontendModule;

use Contao\CoreBundle\Controller\FrontendModule\AbstractFrontendModuleController;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\ModuleModel;
use Contao\Template;
use Mstudio\ContaoSimpleCart\Model\ProductModel;
use Mstudio\ContaoSimpleCart\Service\CartService;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class ShoppingCartController extends AbstractFrontendModuleController
{
    public const TYPE = 'shopping_cart';

    public function __construct(
        private readonly CartService $cartService,
        private readonly RouterInterface $router,
        private readonly ScopeMatcher $scopeMatcher
    ) {
    }

    protected function getResponse(Template $template, ModuleModel $model, Request $request): Response
    {
        if ($this->scopeMatcher->isFrontendRequest($request)) {
            // Handle add to cart
            if ($request->request->has('productId') && $request->request->has('add')) {
                $this->cartService->add((int) $request->request->get('productId'));
                return $this->reloadPage($request);
            }

            // Handle update cart
            if ($request->request->has('update')) {
                $quantities = $request->request->all('quantity');
                foreach ($quantities as $productId => $quantity) {
                    $this->cartService->update((int) $productId, (int) $quantity);
                }
                return $this->reloadPage($request);
            }
        }

        // Get products for the list
        $products = ProductModel::findAll();
        $template->products = $products;

        // Get cart content
        $template->cart = $this->cartService->getCartItems();

        // Find the checkout page URL
        $checkoutPage = PageModel::findWithDetails($model->jumpTo);
        $template->checkout_page_url = $checkoutPage ? $checkoutPage->getAbsoluteUrl() : '';

        return $template->getResponse();
    }

    private function reloadPage(Request $request): Response
    {
        // Redirect to the same page to prevent form resubmission
        return $this->redirect($this->router->generate($request->attributes->get('_route'), $request->attributes->get('_route_params')));
    }
}
