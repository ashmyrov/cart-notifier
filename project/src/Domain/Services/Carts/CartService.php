<?php

namespace App\Domain\Services\Carts;

use App\Domain\Repositories\Carts\CartsRepositoryInterface;
use App\Entity\Cart;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class CartService implements CartServiceInterface
{
    private CartsRepositoryInterface $cartsRepository;
    private LoggerInterface $logger;

    public function __construct(CartsRepositoryInterface $cartsRepository, LoggerInterface $logger)
    {
        $this->cartsRepository = $cartsRepository;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function create(FormInterface $cartForm): Cart
    {

        if (!$cartForm->isSubmitted() || !$cartForm->isValid()) {
            // TODO: Validation errors
            throw new ValidatorException('Validation error.');
        }

        /** @var Cart $cart */
        $cart = $cartForm->getData();
        $cart->setStatus(Cart::STATUS_PENDING);
        $this->cartsRepository->save($cart);

        return $cart;
    }

    /**
     * @inheritDoc
     */
    public function update(FormInterface $cartForm): Cart
    {
        if (!$cartForm->isSubmitted() || !$cartForm->isValid()) {
            // TODO: Validation errors
            throw new ValidatorException('Validation error.');
        }

        $cart = $cartForm->getData();
        $this->cartsRepository->save($cart);

        return $cart;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->cartsRepository->all();
    }

    /**
     * @inheritDoc
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Cart
    {
        try {
            return $this->cartsRepository->getById($id);
        } catch (EntityNotFoundException $exception) {
            $this->logger->info($exception->getMessage(), [
                'body' => [
                    'id' => $id
                ]
            ]);
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     * @throws EntityNotFoundException
     */
    public function remove(int $id): void
    {
        try {
            $cart = $this->cartsRepository->getById($id);
        } catch (EntityNotFoundException $exception) {
            $this->logger->info($exception->getMessage(), [
                'body' => [
                    'id' => $id
                ]
            ]);
            throw $exception;
        }

        $this->cartsRepository->delete($cart);
    }
}
