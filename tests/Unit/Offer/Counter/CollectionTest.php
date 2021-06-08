<?php

namespace App\Offer\Counter;

use Iterator;
use Mockery;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testShouldReturnAnIterator(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $collection = new Collection($offers);

        // Actions
        $result = $collection->getIterator();

        // Assertions
        $this->assertInstanceOf(Iterator::class, $result);
    }

    public function testShouldGetValidOffer(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $collection = new Collection($offers);

        // Actions
        $result = $collection->get(0);

        // Assertions
        $this->assertInstanceOf(Offer::class, $result);
    }

    public function testShouldReturnNullWhenAccessInvalidIndex  (): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $collection = new Collection($offers);

        // Actions
        $result = $collection->get(1);

        // Assertions
        $this->assertNull($result);
    }

    public function testShouldAddAnOfferIntoIterator(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $collection = new Collection($offers);

        // Actions
        $collection->add(Mockery::mock(Offer::class));
        $result = count($collection->getIterator()->toArray());

        // Assertions
        $this->assertSame(2, $result);
    }

    /**
     * @dataProvider getPriceRangeScenarios
     */
    public function testShouldReturnQuantityOfOfferByPriceRange(float $lowerPrice, float $higherPrice, int $expected): void
    {
        // Set
        $attributes = [
            'id' => 1,
            'productTitle' => 'Lorem',
            'vendorId' => 23,
            'price' => 12.99
        ];
        $offers = [Mockery::mock(Offer::class, [$attributes])->makePartial()];
        $collection = new Collection($offers);

        // Actions
        $result = $collection->getOffersByRange($lowerPrice, $higherPrice);

        // Assertions
        $this->assertsame($expected, $result);
    }

    /**
     * @dataProvider getVendorIdScenarios
     */
    public function testShouldReturnQuantityOfOfferByVendorId(int $vendorId, int $expected): void
    {
        // Set
        $attributes = [
            'id' => 1,
            'productTitle' => 'Lorem',
            'vendorId' => 23,
            'price' => 12.99
        ];
        $offers = [Mockery::mock(Offer::class, [$attributes])->makePartial()];
        $collection = new Collection($offers);

        // Actions
        $result = $collection->getOffersByVendorId($vendorId);

        // Assertions
        $this->assertsame($expected, $result);
    }

    public function getPriceRangeScenarios(): array
    {
        return [
            'between price range' => [
                'lowerPrice' => 10.99,
                'higherPrice' => 13.00,
                'expected' => 1,
            ],
            'not between price range' =>[
                'lowerPrice' => 10.99,
                'higherPrice' => 12.98,
                'expected' => 0,
            ],
        ];
    }

    public function getVendorIdScenarios(): array
    {
        return [
            'belongs to vendor id' => [
                'vendorId' => 23,
                'expected' => 1,
            ],
            'do not belong to vendor id' =>[
                'vendorId' => 25,
                'expected' => 0,
            ],
        ];
    }
}
