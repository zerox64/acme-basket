<?php
namespace Acme\Basket;

use Acme\Basket\Product;
use InvalidArgumentException;

class Catalog
{
    /** @var Product[] */
    private array $products;

    /**
     * @param Product[] $products
     */
    public function __construct(array $products)
    {
        $this->products = [];
        foreach ($products as $product) {
            $this->products[$product->code] = $product;
        }
    }

    public function getByCode(string $code): Product
    {
        if (!isset($this->products[$code])) {
            throw new InvalidArgumentException("Product code '$code' not found.");
        }
        return $this->products[$code];
    }
}