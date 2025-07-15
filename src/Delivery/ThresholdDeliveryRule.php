<?php
namespace Acme\Delivery;

class ThresholdDeliveryRule implements DeliveryRuleInterface
{
    public function __construct(
        private float $minSubtotal,
        private ?float $maxSubtotal,
        private float $fee
    ) {}

    public function applies(float $subtotal): bool
    {
        $maxCheck = $this->maxSubtotal === null || $subtotal < $this->maxSubtotal;
        return $subtotal >= $this->minSubtotal && $maxCheck;
    }

    public function fee(): float
    {
        return $this->fee;
    }
}
