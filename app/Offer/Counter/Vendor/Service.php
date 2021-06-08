<?php

namespace App\Offer\Counter\Vendor;

use App\Offer\Counter\ApiFetcher;
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

        return $collection->getOffersByVendorId($vendorId);
    }
}
