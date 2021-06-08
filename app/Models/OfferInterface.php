<?php

namespace App\Models;

interface OfferInterface
{
    public function getId(): int;
    public function getProductTitle(): string;
    public function getVendorId(): int;
    public function getPrice(): float;
}
