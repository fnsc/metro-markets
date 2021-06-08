<?php

namespace App\Offer\Counter;

use Tests\TestCase;

class OfferTest extends TestCase
{
    public function testShouldReturnOfferAttributes(): void
    {
        // Set
        $attributes = [
            'offerId' => 1,
            'productTitle' => 'Lorem Ipsum',
            'vendorId' => 35,
            'price' => 19.99,
        ];
        $offer = new Offer($attributes);

        // Actions
        $id = $offer->getId();
        $productTitle = $offer->getProductTitle();
        $vendorId = $offer->getVendorId();
        $price = $offer->getPrice();

        // Assertions
        $this->assertSame($attributes['offerId'], $id);
        $this->assertSame($attributes['productTitle'], $productTitle);
        $this->assertSame($attributes['vendorId'], $vendorId);
        $this->assertSame($attributes['price'], $price);

    }
}
