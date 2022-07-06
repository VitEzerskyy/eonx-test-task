<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\Customer;

interface HandlerInterface
{
    public function createCustomer(array $customerData): Customer;
    public function updateCustomer(Customer $customer, array $customerData): Customer;
}
