<?php

declare(strict_types=1);

namespace App\Provider\Api;

use App\Entity\Customer;
use App\Provider\HandlerInterface;

class DataHandler implements HandlerInterface
{
    public function createCustomer(array $customerData): Customer
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

    public function updateCustomer(Customer $customer, array $customerData): Customer
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