<?php

namespace App\Services;

use App\Collections\OfferCollectionInterface;

interface ReaderInterface
{
    public function read(array $input): OfferCollectionInterface;
}
