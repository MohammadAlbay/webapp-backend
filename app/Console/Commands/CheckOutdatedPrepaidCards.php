<?php

namespace App\Console\Commands;

use App\Models\PrepaidCard;
use App\Models\Technicain;
use Illuminate\Console\Command;

class CheckOutdatedPrepaidCards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outdated-prepaidcards:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prepaidcards = PrepaidCard::where('state', "Active")->get();
        $currentDate = now();
        $canceledCards = 0;
        foreach ($prepaidcards as $card) {
            $outdatedDate = $card->created_at->addWeeks(4);

            if($currentDate > $outdatedDate) {
                $card->state = "Cancled";
                $card->save();

                $canceledCards++;
            }
        }

        $this->info('Prepaid cards canceled:'.$canceledCards);
    }
}
