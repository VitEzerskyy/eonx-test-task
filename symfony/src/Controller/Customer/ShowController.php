<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Representation\Customer\ShowRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customers/{id}', name: 'customer_show', requirements: ["id" => "\d+"], methods: ["GET"])]
class ShowController
{
    public function __invoke(int $id, CustomerRepository $customerRepository, ShowRepresentation $representation): JsonResponse
    {
        /** @var Customer|null $customer */
        $customer = $customerRepository->findOneBy(['id' => $id]);

        if (!$customer instanceof Customer) {
            throw new NotFoundHttpException('User not found');
        }

        return new JsonResponse($representation->build($customer));
    }
}