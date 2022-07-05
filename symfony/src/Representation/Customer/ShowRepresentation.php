<?php

declare(strict_types=1);

namespace App\Representation\Customer;

use App\Entity\Customer;

class ShowRepresentation
{
    public function build(Customer $customer): array
    {
        return [
            'id' => $customer->getId(),
            'fullName' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
            'username' => $customer->getUsername(),
            'gender' => $customer->getGender(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone()
        ];
    }
}
