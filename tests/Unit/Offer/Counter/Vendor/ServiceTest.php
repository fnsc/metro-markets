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
    /**
     * @dataProvider getVendorIdScenarios
     */
    public function testShouldReturnNumberOfOffersByVendorId(int $vendorId, int $expected): void
    {
        // Set
        $fetcher = Mockery::mock(ApiFetcher::class);
        $reader = Mockery::mock(Reader::class);
        $offer1 = Mockery::mock(Offer::class, [
            [
                "offerId" => 123,
                "productTitle" => "Coffee machine",
                "vendorId" => 35,
                "price" => 390.4
            ]
        ])->makePartial();
        $offer2 = Mockery::mock(Offer::class, [
            [
                "offerId" => 124,
                "productTitle" => "Napkins",
                "vendorId" => 15,
                "price" => 15.5
            ]
        ])->makePartial();
        $offers = [$offer1, $offer2];
        $collection = Mockery::mock(Collection::class, [$offers])->makePartial();
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
                    "vendorId" => 15,
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

        // Actions
        $result = $service->handle($vendorId);

        // Assertions
        $this->assertSame($expected, $result);
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

    public function getVendorIdScenarios(): array
    {
        return [
            'belongs to vendor id' => [
                'vendorId' => 35,
                'expected' => 1,
            ],
            'do not belong to vendor id' =>[
                'vendorId' => 25,
                'expected' => 0,
            ],
        ];
    }
}
