<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AdInsights;
use App\Facebook\FacebookRequest;

class UpdateInsights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insights:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all insights in the database.';

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
     * @return mixed
     */
    public function handle(FacebookRequest $facebook)
    {
        $ads = AdInsights::all();
        foreach ($ads as $ad) {
            $response = $facebook->get()->ad($ad->object_id)->insights();
            $ad->json = $response;
            $ad->save();
        }
        $this->comment('All ads have been updated.');
    }
}
