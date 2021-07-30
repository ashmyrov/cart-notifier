<?php

namespace App\Domain\Repositories\Carts;

use App\Entity\Cart;
use Doctrine\ORM\EntityNotFoundException;

interface CartsRepositoryInterface
{
    /**
     * Create or update cart
     * @param Cart $cart
     */
    public function save(Cart $cart): void;

    /**
     * Find all carts
     * @return array
     */
    public function all(): array;

    /**
     * Find cart by id
     * @param int $id
     *
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Cart;

    /**
     * Delete cart
     * @param Cart $cart
     */
    public function delete(Cart $cart): void;

    /**
     * Find old carts
     * @return array
     */
    public function getOld(): array;
}
