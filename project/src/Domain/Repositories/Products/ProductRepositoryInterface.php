<?php


namespace App\Domain\Repositories\Products;


use App\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * @param Product $product
     *
     * @return void
     */
    public function create(Product $product): void;

    /**
     * @return Product[]
     */
    public function getAll(): array;
}
