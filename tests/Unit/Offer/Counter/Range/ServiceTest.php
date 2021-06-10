<?php

namespace App\Offer\Counter\Range;

use App\Offer\Counter\ApiFetcher;
use App\Offer\Counter\Collection;
use App\Offer\Counter\Offer;
use App\Offer\Counter\Reader;
use Mockery;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    /**
     * @dataProvider getPriceRangeScenarios
     */
    public function testShouldReturnNumberOfOffersByPriceRange(float $lowerPrice, float $higherPrice, int $expected): void
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
                "vendorId" => 35,
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

        // Actions
        $result = $service->handle($lowerPrice, $higherPrice);

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
        $result = $service->handle(15.0, 16.99);

        // Assertions
        $this->assertSame(0, $result);
    }

    public function getPriceRangeScenarios(): array
    {
        return [
            'between price range' => [
                'lowerPrice' => 10.99,
                'higherPrice' => 15.99,
                'expected' => 1,
            ],
            'not between price range' =>[
                'lowerPrice' => 10.99,
                'higherPrice' => 12.98,
                'expected' => 0,
            ],
        ];
    }
}
