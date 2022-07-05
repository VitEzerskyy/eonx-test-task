<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use App\Repository\CustomerRepository;
use App\Representation\Customer\ListRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customers', name: 'customer_list', methods: ["GET"])]
class ListController
{
    public function __invoke(CustomerRepository $customerRepository, ListRepresentation $representation): JsonResponse
    {
        $customers = $customerRepository->findAll();

        return new JsonResponse($representation->build($customers));
    }
}