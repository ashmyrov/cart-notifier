<?php

namespace App\Controller;

use App\Domain\Services\Products\ProductServiceInterface;
use App\Form\Type\ProductType;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;

class ProductController extends AbstractApiController
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @Route("/api/v1/products", name="products.get.products", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $products = $this->productService->get();

        return $this->respond($products);
    }

    /**
     * @Route("/api/v1/products", name="products.create.product", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(ProductType::class);
        $form->handleRequest($request);

        try {
            $customer = $this->productService->create($form);
        } catch (ValidatorException $exception) {
            return $this->respond('Validation error', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->respond($customer, Response::HTTP_CREATED);
    }
}
