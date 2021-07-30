<?php


namespace App\Domain\Services\Customers;


use App\Entity\Customer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

interface CustomerServiceInterface
{
    /**
     * Create a customer
     *
     * @param FormInterface $customerForm
     *
     * @return Customer
     * @throws ValidatorException
     */
    public function create(FormInterface $customerForm): Customer;

    /**
     * Return all customers
     *
     * @return Customer[]
     */
    public function get(): array;
}
