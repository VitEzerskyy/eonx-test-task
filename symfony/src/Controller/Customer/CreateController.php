<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use App\Importer\Api\DataImporter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/customers/create', name: 'customer_create', methods: ["POST"])]
class CreateController
{
    public function __invoke(DataImporter $importer): JsonResponse
    {
        $importer->import();

        return new JsonResponse([], Response::HTTP_CREATED);
    }
}