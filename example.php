<?php

require_once __DIR__ . '/vendor/autoload.php';

use Acme\Basket\{Basket, Catalog, Product};
use Acme\Offer\BuyOneGetHalfOffRule;
use Acme\Delivery\ThresholdDeliveryRule;

$catalog = new Catalog([
    new Product('Red Widget', 'R01', 32.95),
    new Product('Green Widget', 'G01', 24.95),
    new Product('Blue Widget', 'B01', 7.95),
]);

$offerRules = [
    new BuyOneGetHalfOffRule('R01'),
];

$deliveryRules = [
    new ThresholdDeliveryRule(0, 50, 4.95),
    new ThresholdDeliveryRule(50, 90, 2.95),
    new ThresholdDeliveryRule(90, null, 0.00),
];

$basket = new Basket($catalog, $offerRules, $deliveryRules);

foreach (["B01", "B01", "R01", "R01", "R01"] as $code) {
    $basket->add($code);
}

echo "Total: $" . number_format($basket->total(), 2) . PHP_EOL;
