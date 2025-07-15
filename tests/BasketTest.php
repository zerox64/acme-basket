<?php

use PHPUnit\Framework\TestCase;
use Acme\Basket\{Basket, Catalog, Product};
use Acme\Offer\BuyOneGetHalfOffRule;
use Acme\Delivery\ThresholdDeliveryRule;

class BasketTest extends TestCase
{
    private function createCatalog(): Catalog
    {
        return new Catalog([
            new Product('Red Widget', 'R01', 32.95),
            new Product('Green Widget', 'G01', 24.95),
            new Product('Blue Widget', 'B01', 7.95),
        ]);
    }

    /**
     * @return \Acme\Delivery\DeliveryRuleInterface[]
     */
    private function createDeliveryRules(): array
    {
        return [
            new ThresholdDeliveryRule(0, 50, 4.95),
            new ThresholdDeliveryRule(50, 90, 2.95),
            new ThresholdDeliveryRule(90, null, 0.0),
        ];
    }

    public function test_total_without_discounts_or_delivery(): void
    {
        $catalog = $this->createCatalog();
        $basket = new Basket($catalog);

        $basket->add('B01');
        $basket->add('G01');

        $this->assertEquals(32.90, $basket->total());
    }

    public function test_total_with_discount_and_delivery(): void
    {
        $catalog = $this->createCatalog();
        $offerRules = [new BuyOneGetHalfOffRule('R01')];
        $deliveryRules = $this->createDeliveryRules();

        $basket = new Basket($catalog, $offerRules, $deliveryRules);

        $basket->add('R01');
        $basket->add('R01');

        $this->assertEquals(54.37, $basket->total());
    }

    public function test_free_delivery_above_threshold(): void
    {
        $catalog = $this->createCatalog();
        $deliveryRules = $this->createDeliveryRules();

        $basket = new Basket($catalog, [], $deliveryRules);
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $subtotal = number_format(32.95 * 3, 2);
        $this->assertGreaterThanOrEqual(90, $subtotal);
        $this->assertEquals($subtotal, $basket->total());
    }
}