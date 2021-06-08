<?php

namespace App\Offer\Counter;

use Mockery;
use PHPUnit\Framework\TestCase;

class OfferIteratorTest extends TestCase
{
    public function testShouldReturnCurrentOffer(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->current();

        // Assertions
        $this->assertInstanceOf(Offer::class, $result);
    }

    public function testShouldReturnNullWhenInvalidOffset(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $iterator = new OfferIterator($offers);

        // Actions
        $iterator->next();
        $result = $iterator->current();

        // Assertions
        $this->assertNull($result);
    }

    public function testShouldReturnAnOfferObjectWhenNextIsCalled(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->next();

        // Assertions
        $this->assertInstanceOf(Offer::class, $result);
    }

    public function testShouldReturnNullWhenNextReachesAnInvalidOffset(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->next();

        // Assertions
        $this->assertNull($result);
    }

    public function testShouldReturnCurrentKey(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->key();

        // Assertions
        $this->assertSame(0, $result);
    }

    public function testShouldReturnIfTheCurrentOffsetIsValid(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->valid();

        // Assertions
        $this->assertTrue($result);
    }

    public function testShouldAssertIfTheCurrentOffsetIsValidAndReturnFalse(): void
    {
        // Set
        $offers = [Mockery::mock(Offer::class)];
        $iterator = new OfferIterator($offers);

        // Actions
        $iterator->next();
        $result = $iterator->valid();

        // Assertions
        $this->assertFalse($result);
    }

    public function testShouldRewindTheCursor(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $iterator->next();
        $iterator->rewind();

        // Assertions
        $this->assertSame(0, $iterator->key());
    }

    public function testShouldAddAnotherOffer(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $iterator->add($offer);

        // Assertions
        $this->assertSame(3, count($iterator->toArray()));
    }

    public function testShouldGetOfferFromIndex(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->get(1);

        // Assertions
        $this->assertInstanceOf(Offer::class, $result);
    }

    public function testShouldReturnNullWhenGetAnInvalidOffset(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->get(2);

        // Assertions
        $this->assertNull($result);
    }

    public function testShouldReturnAnArrayOfOffers(): void
    {
        // Set
        $offer = Mockery::mock(Offer::class);
        $offers = [$offer, $offer];
        $iterator = new OfferIterator($offers);

        // Actions
        $result = $iterator->toArray();

        // Assertions
        $this->assertSame($offers, $result);
    }
}
