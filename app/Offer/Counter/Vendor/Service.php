<?php

namespace App\Offer\Counter\Vendor;

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

    public function handle(int $vendorId): int
    {
        $result = $this->apiFetcher->fetch();
        $result = json_decode($result, true);

        if (!count($result['data'])) {
            return 0;
        }

        $collection = $this->reader->read($result['data']);

        return $this->getOffersByVendorId($collection, $vendorId);
    }

    public function getOffersByVendorId(OfferCollectionInterface $collection, int $vendorId): int
    {
        $counter = [];
        $offers = $collection->getIterator();
        foreach ($offers as $offer) {
            if (!$this->belongsTo($vendorId, $offer)) {
                continue;
            }
            $counter[] = $offer;
        }

        return count($counter);
    }

    private function belongsTo(int $vendorId, OfferInterface $offer): bool
    {
        return $offer->getVendorId() === $vendorId;
    }
}
