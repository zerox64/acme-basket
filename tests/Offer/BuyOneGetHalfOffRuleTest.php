<?php

use PHPUnit\Framework\TestCase;
use Acme\Offer\BuyOneGetHalfOffRule;
use Acme\Basket\Product;

class BuyOneGetHalfOffRuleTest extends TestCase
{
    public function test_applies_to_one_pair(): void
    {
        $rule = new BuyOneGetHalfOffRule('R01');
        $items = [
            new Product('Red Widget', 'R01', 30.00),
            new Product('Red Widget', 'R01', 30.00),
        ];

        $result = $rule->apply($items, 60.00);
        $this->assertEquals(45.00, $result);
    }

    public function test_applies_to_odd_number(): void
    {
        $rule = new BuyOneGetHalfOffRule('R01');
        $items = [
            new Product('Red Widget', 'R01', 30.00),
            new Product('Red Widget', 'R01', 30.00),
            new Product('Red Widget', 'R01', 30.00),
        ];

        $result = $rule->apply($items, 90.00);
        $this->assertEquals(75.00, $result);
    }

    public function test_ignores_other_products(): void
    {
        $rule = new BuyOneGetHalfOffRule('R01');
        $items = [
            new Product('Green Widget', 'G01', 20.00),
            new Product('Blue Widget', 'B01', 10.00),
        ];

        $result = $rule->apply($items, 30.00);
        $this->assertEquals(30.00, $result);
    }
}
