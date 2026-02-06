<?php

declare(strict_types=1);

namespace Mstudio\ContaoSimpleCart\Service;

use Mstudio\ContaoSimpleCart\Model\ProductModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @method static findByIds(array $productIds)
 */
class CartService
{
    private const SESSION_KEY = 'contao_simple_cart';

    private SessionInterface $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->getCart();
        
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        $this->session->set(self::SESSION_KEY, $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->getCart();

        if ($quantity > 0) {
            $cart[$productId] = $quantity;
        } else {
            unset($cart[$productId]);
        }

        $this->session->set(self::SESSION_KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->session->set(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        $this->session->remove(self::SESSION_KEY);
    }

    public function getCart(): array
    {
        return $this->session->get(self::SESSION_KEY, []);
    }

    public function getCartItems(): array
    {
        $cart = $this->getCart();
        $items = [];
        $total = 0.0;

        if (empty($cart)) {
            return ['items' => [], 'total' => 0.0];
        }

        $productIds = array_keys($cart);
        $products = ProductModel::findByIds($productIds);

        if (null === $products) {
            return ['items' => [], 'total' => 0.0];
        }

        foreach ($products as $product) {
            $quantity = $cart[$product->id];
            $itemTotal = $product->price * $quantity;
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'total' => $itemTotal,
            ];
            $total += $itemTotal;
        }

        return ['items' => $items, 'total' => $total];
    }
}
