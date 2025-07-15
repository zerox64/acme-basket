<?php
namespace Acme\Basket;

class Product
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
        public readonly float $price
    ) {}
}