<?php

namespace App\Offer\Counter;

use Iterator;

class OfferIterator implements Iterator
{
    private int $current = 0;
    private array $offers;

    public function __construct(array $offers)
    {
        foreach ($offers as $offer) {
            $this->setOffers($offer);
        }
    }

    public function current(): ?OfferInterface
    {
        return $this->offers[$this->current] ?? null;
    }

    public function next(): ?OfferInterface
    {
        $this->current++;
        return $this->offers[$this->current] ?? null;
    }

    public function key(): int
    {
        return $this->current;
    }

    public function valid(): bool
    {
        return isset($this->offers[$this->current]);
    }

    public function rewind(): void
    {
        $this->current = 0;
    }

    public function add(Offer $offer): void
    {
        $this->offers[] = $offer;
    }

    public function get(int $index): ?OfferInterface
    {
        return $this->offers[$index] ?? null;
    }

    public function toArray(): array
    {
        return $this->offers;
    }

    private function setOffers($offer): void
    {
        if ($offer instanceof OfferInterface) {
            $this->offers[] = $offer;
        }
    }
}
