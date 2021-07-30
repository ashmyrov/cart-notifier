<?php


namespace App\Domain\Services\Carts;

use App\Entity\Cart;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

interface CartServiceInterface
{
    /**
     * Create cart
     * @param FormInterface $cartForm
     *
     * @return Cart
     * @throws ValidatorException
     */
    public function create(FormInterface $cartForm): Cart;

    /**
     * Update cart
     * @param FormInterface $cartForm
     *
     * @return Cart
     * @throws ValidatorException
     */
    public function update(FormInterface $cartForm): Cart;

    /**
     * Find all carts
     * @return Cart[]
     */
    public function get(): array;

    /**
     * Find cart by id
     * @param int $id
     *
     * @return Cart
     */
    public function getById(int $id): Cart;

    /**
     * Remove cart by id
     * @param int $id
     */
    public function remove(int $id): void;
}
