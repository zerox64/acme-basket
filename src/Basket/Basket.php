<?php
namespace Acme\Basket;

use Acme\Basket\Product;
use Acme\Offer\OfferRuleInterface;
use Acme\Delivery\DeliveryRuleInterface;

class Basket
{
    /** @var Product[] */
    private array $items = [];

    /**
     * @param OfferRuleInterface[] $offerRules
     * @param DeliveryRuleInterface[] $deliveryRules
     */
    public function __construct(
        private readonly Catalog $catalog,
        private readonly array $offerRules = [],
        private readonly array $deliveryRules = []
    ) {}

    public function add(string $productCode): void
    {
        $product = $this->catalog->getByCode($productCode);
        $this->items[] = $product;
    }

    public function total(): float
    {
        $subtotal = $this->applyOffers();
        $deliveryFee = $this->calculateDeliveryFee($subtotal);
        return round($subtotal + $deliveryFee, 2, PHP_ROUND_HALF_DOWN);
    }

    private function applyOffers(): float
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->price;
        }

        foreach ($this->offerRules as $rule) {
            $total = $rule->apply($this->items, $total);
        }

        return $total;
    }

    private function calculateDeliveryFee(float $subtotal): float
    {
        $minFee = null;

        foreach ($this->deliveryRules as $rule) {
            if ($rule->applies($subtotal)) {
                $fee = $rule->fee();
                if ($minFee === null || $fee < $minFee) {
                    $minFee = $fee;
                }
            }
        }

        return $minFee ?? 0.0;
    }
}