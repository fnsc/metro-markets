<?php

namespace App\Offer\Counter;

use Iterator;

class Collection implements OfferCollectionInterface
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

    public function add(Offer $offer): void
    {
        $this->offers->add($offer);
    }

    private function setIterator(array $offers): void
    {
        $this->offers = new OfferIterator($offers);
    }
}
