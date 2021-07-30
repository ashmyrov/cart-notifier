<?php

namespace App\Domain\Services\Products;

use App\Entity\Product;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

interface ProductServiceInterface
{
    /**
     * Create a product
     *
     * @param FormInterface $productForm
     *
     * @return Product
     * @throws ValidatorException
     */
    public function create(FormInterface $productForm): Product;

    /**
     * Return all products
     *
     * @return Product []
     */
    public function get(): array;
}
