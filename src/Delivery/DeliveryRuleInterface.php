<?php
namespace Acme\Delivery;

interface DeliveryRuleInterface
{
    public function applies(float $subtotal): bool;
    public function fee(): float;
}