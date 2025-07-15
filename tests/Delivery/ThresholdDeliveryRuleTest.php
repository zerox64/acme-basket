<?php

use PHPUnit\Framework\TestCase;
use Acme\Delivery\ThresholdDeliveryRule;

class ThresholdDeliveryRuleTest extends TestCase
{
    public function test_applies_within_range(): void
    {
        $rule = new ThresholdDeliveryRule(0, 50, 4.95);
        $this->assertTrue($rule->applies(25));
    }

    public function test_does_not_apply_above_max(): void
    {
        $rule = new ThresholdDeliveryRule(0, 50, 4.95);
        $this->assertFalse($rule->applies(50));
        $this->assertFalse($rule->applies(51));
    }

    public function test_applies_with_no_upper_bound(): void
    {
        $rule = new ThresholdDeliveryRule(90, null, 0);
        $this->assertTrue($rule->applies(90));
        $this->assertTrue($rule->applies(120));
    }

    public function test_exclusive_upper_bound(): void
    {
        $rule = new ThresholdDeliveryRule(50, 90, 2.95);
        $this->assertTrue($rule->applies(75));
        $this->assertFalse($rule->applies(90));
    }
}
