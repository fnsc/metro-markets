<?php

namespace App\Console\Commands;

use App\Services\OfferService;
use Illuminate\Console\Command;

class CountOffersByPriceRange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:count_by_price_range {lowerPrice} {higherPrice}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns the amount of offers that match the given range.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param OfferService $offerService
     * @return int
     */
    public function handle(OfferService $offerService): int
    {
        $lowerPrice = (float) $this->argument('lowerPrice');
        $higherPrice = (float) $this->argument('higherPrice');

        return $offerService->getOffersByRange($lowerPrice, $higherPrice);
    }
}
