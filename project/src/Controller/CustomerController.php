<?php


namespace App\Controller;


use App\Domain\Services\Customers\CustomerServiceInterface;
use App\Entity\Customer;
use App\Form\Type\CustomerType;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Exception\ValidatorException;

class CustomerController extends AbstractApiController
{
    private CustomerServiceInterface $customerService;

    public function __construct(CustomerServiceInterface $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * @Route("/api/v1/customers", name="customers.get.customers", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $customers = $this->customerService->get();

        return $this->respond($customers);
    }

    /**
     * @Route("/api/v1/customers", name="customers.create.customer", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(CustomerType::class);
        $form->handleRequest($request);

        try {
            $customer = $this->customerService->create($form);
        } catch (ValidatorException $exception) {
            return $this->respond('Validation error', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->respond($customer, Response::HTTP_CREATED);
    }
}
