<?php

namespace App\Services;

use App\Collections\{OfferCollection, OfferCollectionInterface};
use App\Models\Offer;

class Reader implements ReaderInterface
{
    public function read(array $input): OfferCollectionInterface
    {
        return $this->setCollection($input);
    }

    private function setCollection(array $data): OfferCollectionInterface
    {
        $offers = [];
        foreach ($data as $offer) {
            $offer[] = new Offer($offer);
        }

        return new OfferCollection($offers);
    }
}
