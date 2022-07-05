<?php

declare(strict_types=1);

namespace App\Importer\Api;

use App\Entity\Customer;
use App\Provider\ProviderInterface;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class DataImporter
{
    private ProviderInterface $provider;
    private EntityManagerInterface $entityManager;
    private CustomerRepository $customerRepository;

    public function __construct(ProviderInterface $provider, EntityManagerInterface $entityManager, CustomerRepository $customerRepository)
    {
        $this->provider = $provider;
        $this->entityManager = $entityManager;
        $this->customerRepository = $customerRepository;
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
                    $this->updateCustomer($customer, $customerData);
                    $this->entityManager->persist($customer);

                    continue 2;
                }
            }

            $customer = $this->createCustomer($customerData);
            $this->entityManager->persist($customer);
        }

        $this->entityManager->flush();
    }

    private function createCustomer(array $customerData): Customer
    {
        return (new Customer())
            ->setFirstName($customerData['name']['first'])
            ->setLastName($customerData['name']['last'])
            ->setEmail($customerData['email'])
            ->setCountry($customerData['location']['country'])
            ->setUsername($customerData['login']['username'])
            ->setGender($customerData['gender'])
            ->setCity($customerData['location']['city'])
            ->setPhone($customerData['phone']);
    }

    private function updateCustomer(Customer $customer, array $customerData): Customer
    {
        return $customer
            ->setFirstName($customerData['name']['first'])
            ->setLastName($customerData['name']['last'])
            ->setCountry($customerData['location']['country'])
            ->setUsername($customerData['login']['username'])
            ->setGender($customerData['gender'])
            ->setCity($customerData['location']['city'])
            ->setPhone($customerData['phone']);
    }
}