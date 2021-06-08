<?php

namespace App\Offer\Counter\Vendor;

use App\Offer\Counter\ApiFetcher;
use App\Offer\Counter\Collection;
use App\Offer\Counter\Offer;
use App\Offer\Counter\Reader;
use Mockery;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testShouldReturnQuantityNUmberOfOffersByVendorId(): void
    {
        // Set
        $fetcher = Mockery::mock(ApiFetcher::class);
        $reader = Mockery::mock(Reader::class);
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $collection = Mockery::mock(Collection::class, [$offers]);
        $service = new Service($fetcher, $reader);
        $contents = [
            'message' => 'Success',
            'data' => [
                [
                    "offerId" => 123,
                    "productTitle" => "Coffee machine",
                    "vendorId" => 35,
                    "price" => 390.4
                ],
                [
                    "offerId" => 124,
                    "productTitle" => "Napkins",
                    "vendorId" => 35,
                    "price" => 15.5
                ],
            ],
        ];

        // Expectations
        $fetcher->expects()
            ->fetch()
            ->andReturn(json_encode($contents));

        $reader->expects()
            ->read($contents['data'])
            ->andReturn($collection);

        $collection->expects()
            ->getOffersByVendorId(35)
            ->andReturn(1);

        // Actions
        $result = $service->handle(35);

        // Assertions
        $this->assertSame(1, $result);
    }

    public function testShouldReturnZeroIfApiIsNotWorking(): void
    {
        // Set
        $fetcher = Mockery::mock(ApiFetcher::class);
        $reader = Mockery::mock(Reader::class);
        $service = new Service($fetcher, $reader);
        $contents = [
            'message' => 'Failed',
            'data' => [],
        ];

        // Expectations
        $fetcher->expects()
            ->fetch()
            ->andReturn(json_encode($contents));

        // Actions
        $result = $service->handle(35);

        // Assertions
        $this->assertSame(0, $result);
    }
}
