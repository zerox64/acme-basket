<?php
namespace Acme\Offer;

use Acme\Basket\Product;

class BuyOneGetHalfOffRule implements OfferRuleInterface
{
    public function __construct(private string $productCode) {}

    /**
     * @param Product[] $items
     */
    public function apply(array $items, float $originalTotal): float
    {
        $unitPrice = null;
        $targetCount = 0;
        $otherTotal = 0.0;

        foreach ($items as $item) {
            if ($item->code === $this->productCode) {
                $unitPrice ??= $item->price;
                $targetCount++;
            } else {
                $otherTotal += $item->price;
            }
        }

        if ($targetCount < 2 || $unitPrice === null) {
            return $originalTotal;
        }

        $halfPriceCount = intdiv($targetCount, 2);
        $fullPriceCount = $targetCount - $halfPriceCount;

        $targetTotal = ($fullPriceCount * $unitPrice) + ($halfPriceCount * $unitPrice * 0.5);

        return $targetTotal + $otherTotal;
    }
}