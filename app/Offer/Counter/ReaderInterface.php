<?php

namespace App\Offer\Counter;

interface ReaderInterface
{
    public function read(array $input): OfferCollectionInterface;
}
