<?php
namespace Acme\Offer;

use Acme\Basket\Product;

interface OfferRuleInterface
{
    /**
     * @param Product[] $items
     */
    public function apply(array $items, float $originalTotal): float;
}