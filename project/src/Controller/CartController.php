<?php

namespace App\Controller;

use App\Domain\Services\Carts\CartServiceInterface;
use App\Form\Type\CartType;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;

class CartController extends AbstractApiController
{
    private CartServiceInterface $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/api/v1/carts", name="carts.get.carts", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $carts = $this->cartService->get();

        return $this->respond($carts);
    }

    /**
     * @Route("/api/v1/carts", name="carts.create.cart", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(CartType::class);
        $form->handleRequest($request);

        try {
            $carts = $this->cartService->create($form);
        } catch (ValidatorException $exception) {
            return $this->respond('Validation error', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->respond($carts, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/v1/carts/{id}", name="carts.update.cart", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateAction(Request $request): Response
    {
        $cart = $this->cartService->getById($request->get('id'));

        $form = $this->buildForm(CartType::class, $cart, [
            'method' => $request->getMethod(),
        ]);
        $form->handleRequest($request);

        try {
            $cart = $this->cartService->update($form);
        } catch (\Exception $exception) {
            throw $exception;
        }

        return $this->respond($cart);
    }

    /**
     * @Route("/api/v1/carts/{id}", name="carts.delete.cart", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAction(Request $request): Response
    {
        $this->cartService->remove($request->get('id'));

        return $this->respond(null, Response::HTTP_NO_CONTENT);
    }
}
