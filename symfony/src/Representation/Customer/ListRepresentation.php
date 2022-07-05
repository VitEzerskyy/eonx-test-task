<?php

declare(strict_types=1);

namespace App\Representation\Customer;

use App\Entity\Customer;

class ListRepresentation
{
    /**
     * @param Customer[] $customers
     */
    public function build(array $customers): array
    {
        if (!$customers) {
            return [];
        }

        $collection = [];

        foreach ($customers as $customer) {
            $collection[] = [
                'id' => $customer->getId(),
                'fullName' => $customer->getFullName(),
                'email' => $customer->getEmail(),
                'country' => $customer->getCountry()
            ];
        }

        return $collection;
    }
}
