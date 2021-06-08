<?php

namespace App\Models;

class Offer implements OfferInterface
{
    private int $id;
    private string $productTitle;
    private int $vendorId;
    private float $price;

    public function __construct(array $offer)
    {
        $this->id = $offer['offerId'];
        $this->productTitle = $offer['productTitle'];
        $this->vendorId = $offer['vendorId'];
        $this->price = $offer['price'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductTitle(): string
    {
        return $this->productTitle;
    }

    public function getVendorId(): int
    {
        return $this->vendorId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
