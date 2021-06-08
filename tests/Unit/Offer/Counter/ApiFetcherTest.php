<?php

namespace App\Offer\Counter;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class ApiFetcherTest extends TestCase
{
    public function testShouldReceive200HttpStatus(): void
    {
        // Set
        $client = Mockery::mock(Client::class);
        $logger = app(LoggerInterface::class);
        $response = Mockery::mock(ResponseInterface::class);
        $streamInterface = Mockery::mock(StreamInterface::class);
        $contents = [
            'message' => 'Success',
            'data' => [
                [
                    "offerId" => 123,
                    "productTitle" => "Coffee machine",
                    "vendorId" => 35,
                    "price" => 390.4
                ],
            ]
        ];
        $fetcher = new ApiFetcher($client, $logger);

        // Expectations
        $client->expects()
            ->get('http://localhost')
            ->andReturn($response);

        $response->expects()
            ->getBody()
            ->andReturn($streamInterface);

        $streamInterface->expects()
            ->getContents()
            ->andReturn(json_encode($contents));

        // Actions
        $result = $fetcher->fetch();

        // Assertions
        $this->assertSame(json_encode($contents), $result);
    }

    public function testShouldThrownAnException(): void
    {
        // Set
        $client = Mockery::mock(Client::class);
        $logger = app(LoggerInterface::class);
        $fetcher = new ApiFetcher($client, $logger);
        $contents = [
            'message' => 'Failed',
            'data' => [],
        ];

        // Expectations
        $client->expects()
            ->get('http://localhost')
            ->andThrow(new Exception('Api is not working'));

        // Actions
        $result = $fetcher->fetch();

        // Assertions
        $this->assertSame(json_encode($contents), $result);
    }
}
