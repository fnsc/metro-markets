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
}
