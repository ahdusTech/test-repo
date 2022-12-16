<?php

namespace App\Console\Commands;

use App\Domain;
use App\Mail\GenralAuctionMail;
use App\Models\Admin\Auction;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAuction;
use App\Models\Customer\CustomerAuctionBid;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BidManagerAuctionClosing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bid_manager_auction_closing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run every 30 mints';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        parent::__construct();
    }*/

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*$this::auction_sold();
        $this::auction_ended();
        $this::auction_started();
        $this::price_droped();
        Log::info('Bid Automation Ended '. Carbon::now()->format('d-m-Y H:i'));*/
        return true;
    }
}
