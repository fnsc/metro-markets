<?php

namespace App\Services;


use App\Collections\OfferCollectionInterface;

class OfferService
{
    private ApiFetcher $apiFetcher;
    private Reader $reader;

    public function __construct(ApiFetcher $apiFetcher, Reader $reader)
    {
        $this->apiFetcher = $apiFetcher;
        $this->reader = $reader;
    }

    public function getOffersByVendorId(int $vendorId): int
    {
        $collection = $this->getCollection();

        return $collection->getOffersByVendorId($vendorId);
    }

    public function getOffersByRange(float $lowerPrice, float $higherPrice): int
    {
        $collection = $this->getCollection();

        return $collection->getOffersByRange($lowerPrice, $higherPrice);
    }

    protected function getCollection(): OfferCollectionInterface
    {
        $result = $this->apiFetcher->fetch();
        $result = json_decode($result, true);

        return $this->reader->read($result['data'] ?? []);
    }
}
