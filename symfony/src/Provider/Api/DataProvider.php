<?php

declare(strict_types=1);

namespace App\Provider\Api;

use App\Client\Api\Client;
use App\Provider\ProviderInterface;

class DataProvider implements ProviderInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getData(): array
    {
        return $this->download();
    }

    private function download(): array
    {
        return $this->client->customersList()['results'];
    }
}