<?php


namespace App\Domain\Services\Customers;


use App\Domain\Repositories\Customers\CustomerRepositoryInterface;
use App\Entity\Customer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class CustomerService implements CustomerServiceInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(FormInterface $customerForm): Customer
    {
        if (!$customerForm->isSubmitted() || !$customerForm->isValid()) {
            // TODO: Validation errors
            throw new ValidatorException('Validation error.');
        }

        $customer = $customerForm->getData();
        $this->customerRepository->create($customer);
        return $customer;
    }

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        return $this->customerRepository->getAll();
    }
}
