<?php

namespace App\Offer\Counter\Range;

use App\Offer\Counter\ApiFetcher;
use App\Offer\Counter\OfferCollectionInterface;
use App\Offer\Counter\OfferInterface;
use App\Offer\Counter\Reader;

class Service
{
    private ApiFetcher $apiFetcher;
    private Reader $reader;

    public function __construct(ApiFetcher $apiFetcher, Reader $reader)
    {
        $this->apiFetcher = $apiFetcher;
        $this->reader = $reader;
    }

    public function handle(float $lowerPrice, float $higherPrice): int
    {
        $result = $this->apiFetcher->fetch();
        $result = json_decode($result, true);

        if (!count($result['data'])) {
            return 0;
        }

        $collection = $this->reader->read($result['data']);

        return $this->getOffersByRange($collection, $lowerPrice, $higherPrice);
    }

    private function getOffersByRange(OfferCollectionInterface $collection, float $lowerPrice, float $higherPrice): int
    {
        $counter = 0;
        $offers = $collection->getIterator();
        foreach ($offers as $offer) {
            if (!$this->isBetweenPriceRange($offer, $lowerPrice, $higherPrice)) {
                continue;
            }
            $counter++;
        }

        return $counter;
    }

    private function isBetweenPriceRange(OfferInterface $offer, float $lowerPrice, float $higherPrice): bool
    {
        return $offer->getPrice() >= $lowerPrice && $offer->getPrice() <= $higherPrice;
    }
}
