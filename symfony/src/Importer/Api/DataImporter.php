<?php

declare(strict_types=1);

namespace App\Importer\Api;

use App\Provider\HandlerInterface;
use App\Provider\ProviderInterface;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class DataImporter
{
    private ProviderInterface $provider;
    private EntityManagerInterface $entityManager;
    private CustomerRepository $customerRepository;
    private HandlerInterface $handler;

    public function __construct(ProviderInterface $provider, EntityManagerInterface $entityManager, CustomerRepository $customerRepository, HandlerInterface $handler)
    {
        $this->provider = $provider;
        $this->entityManager = $entityManager;
        $this->customerRepository = $customerRepository;
        $this->handler = $handler;
    }

    public function import(): void
    {
        $data = $this->provider->getData();

        if (empty($data)) {
            throw new \RuntimeException('Empty source data');
        }

        $customers = $this->customerRepository->findAll();

        foreach ($data as $customerData) {
            foreach ($customers as $customer) {
                if ($customer->getEmail() === $customerData['email']) {
                    $this->handler->updateCustomer($customer, $customerData);
                    $this->entityManager->persist($customer);

                    continue 2;
                }
            }

            $customer = $this->handler->createCustomer($customerData);
            $this->entityManager->persist($customer);
        }

        $this->entityManager->flush();
    }
}