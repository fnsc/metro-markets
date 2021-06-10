<?php

namespace App\Offer\Counter;

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
            $offers[] = new Offer($offer);
        }

        return new Collection($offers);
    }
}
