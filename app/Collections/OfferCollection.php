<?php

namespace App\Collections;

use App\Models\OfferInterface;
use App\Services\OfferIterator;
use Iterator;

class OfferCollection implements OfferCollectionInterface
{
    private OfferIterator $offers;

    public function __construct(array $offers)
    {
        $this->setIterator($offers);
    }

    public function get(int $index): ?OfferInterface
    {
        return $this->offers->get($index) ?? null;
    }

    public function getIterator(): Iterator
    {
        return $this->offers;
    }

    public function add(OfferInterface $offer): void
    {
        $this->offers->add($offer);
    }

    public function getOffersByRange(float $lowerPrice, float $higherPrice): int
    {
        $counter = 0;
        foreach ($this->offers as $offer) {
            if ($this->isBetweenPriceRange($offer, $lowerPrice, $higherPrice)) {
                $counter++;
            }
        }

        return $counter;
    }

    public function getOffersByVendorId(int $vendorId): int
    {
        $counter = 0;
        foreach ($this->offers as $offer) {
            if ($this->belongsTo($vendorId, $offer)) {
                $counter++;
            }
        }

        return $counter;
    }

    private function isBetweenPriceRange(OfferInterface $offer, float $lowerPrice, float $higherPrice): bool
    {
        $price = $offer->getPrice();
        return $price >= $lowerPrice && $price <= $higherPrice;
    }

    private function belongsTo(int $vendorId, OfferInterface $offer): bool
    {
        return $offer->getVendorId() === $vendorId;
    }

    private function setIterator(array $offers): void
    {
        $this->offers = new OfferIterator($offers);
    }
}
