<?php


namespace App\Domain\Repositories\Customers;


use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class CustomerRepository implements CustomerRepositoryInterface
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Customer::class);
    }

    /**
     * @inheritDoc
     */
    public function create(Customer $customer): void
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}
