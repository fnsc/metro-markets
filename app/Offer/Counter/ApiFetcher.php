<?php

namespace App\Offer\Counter;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class ApiFetcher
{
    private const URI = 'http://localhost';
    private Client $client;
    private LoggerInterface $logger;

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function fetch(): string
    {
        try {
            $response = $this->client->get(self::URI);

            return $response->getBody()->getContents();
        } catch (Exception $exception) {
            $this->logger->error('Api endpoint is not working',
                [
                    'exception' => $exception,
                ]
            );

            return json_encode([
                'message' => 'Failed',
                'data' => [],
            ]);
        }
    }
}
