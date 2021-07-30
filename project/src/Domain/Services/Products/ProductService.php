<?php

namespace App\Domain\Services\Products;

use App\Domain\Repositories\Products\ProductRepositoryInterface;
use App\Entity\Product;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class ProductService implements ProductServiceInterface
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(FormInterface $productForm): Product
    {
        if (!$productForm->isSubmitted() || !$productForm->isValid()) {
            // TODO: Validation errors
            throw new ValidatorException('Validation error.');
        }

        $product = $productForm->getData();
        $this->productRepository->create($product);
        return $product;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->productRepository->getAll();
    }
}
