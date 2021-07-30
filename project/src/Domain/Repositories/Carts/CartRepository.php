<?php

namespace App\Domain\Repositories\Carts;

use App\Entity\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ObjectRepository;

class CartRepository implements CartsRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Cart::class);
    }

    /**
     * @inheritDoc
     */
    public function save(Cart $cart): void
    {
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): Cart
    {
        $cart = $this->repository->findOneBy(['id' => $id]);
        if ($cart === null) {
            throw new EntityNotFoundException(sprintf('Cart %d not found', $id));
        }
        return $cart;
    }

    /**
     * @inheritDoc
     */
    public function delete(Cart $cart): void
    {
        $this->entityManager->remove($cart);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getOld(): array
    {
        return $this->repository->createQueryBuilder('cart')
            ->select('partial cart.{id, create_at}, partial customer.{id, email}, partial products.{id, name, price}')
            ->innerJoin('cart.customer', 'customer')
            ->leftJoin('cart.products', 'products', 'WITH')
            ->andWhere('cart.status = :status')
            ->andWhere('cart.create_at < :create_time')
            ->setParameter(':status', Cart::STATUS_PENDING)
            ->setParameter(':create_time', date('Y-m-d H:i:s', strtotime('-1 week')))
            ->getQuery()
            ->getArrayResult();
    }
}
