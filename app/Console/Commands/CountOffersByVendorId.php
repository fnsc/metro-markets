<?php

namespace App\Console\Commands;

use App\Services\OfferService;
use Illuminate\Console\Command;

class CountOffersByVendorId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:count_by_vendor_id {vendor_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns the amount of offers that belongs to the given vendor (by id)';

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
        $vendorId = (int) $this->argument('vendor_id');

        return $offerService->getOffersByVendorId($vendorId);
    }
}
