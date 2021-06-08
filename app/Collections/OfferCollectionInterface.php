<?php

namespace App\Collections;

use App\Models\OfferInterface;
use Iterator;

interface OfferCollectionInterface
{
    public function get(int $index): ?OfferInterface;
    public function getIterator(): Iterator;
}
