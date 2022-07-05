<?php

declare(strict_types=1);

namespace App\Client\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class Client
{
    private ClientInterface $client;
    private LoggerInterface $logger;
    private string $count;
    private string $nationality;
    private string $host;

    public function __construct(string $dsn, ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;

        $parsedDsn = parse_url($dsn);
        $this->host = sprintf(
            '%s://%s%s',
            $parsedDsn['scheme'],
            $parsedDsn['host'],
            $parsedDsn['path']
        );

        parse_str($parsedDsn['query'], $parsedQuery);
        $this->count = $parsedQuery['results'];
        $this->nationality = $parsedQuery['nat'];
    }

    public function customersList(): array
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->host,
                [
                    'query' => [
                        'results' => $this->count,
                        'nat' => $this->nationality
                    ],
                ]
            );

            return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception | GuzzleException $e) {
            $this->logger->error(sprintf('Error while fetching data: %s', $e->getMessage()));

            throw new \RuntimeException($e->getMessage());
        }
    }
}
