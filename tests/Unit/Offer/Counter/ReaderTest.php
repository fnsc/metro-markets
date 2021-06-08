<?php

namespace App\Offer\Counter;

use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testShouldReturnAnOfferCollection(): void
    {
        // Set
        $offers = [
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
        ];
        $reader = new Reader();

        // Actions
        $result = $reader->read($offers);

        // Assertions
        $this->assertInstanceOf(Collection::class, $result);
    }
}
