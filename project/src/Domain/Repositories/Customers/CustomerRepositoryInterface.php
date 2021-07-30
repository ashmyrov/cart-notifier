<?php


namespace App\Domain\Repositories\Customers;


use App\Entity\Customer;

interface CustomerRepositoryInterface
{
    /**
     * @param Customer $customer
     *
     * @return void
     */
    public function create(Customer $customer): void;

    /**
     * @return Customer[]
     */
    public function getAll(): array;
}
