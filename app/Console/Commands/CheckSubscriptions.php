<?php

namespace App\Console\Commands;

use App\Models\Technicain;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

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
        $technicians = Technicain::where('state', "Active")->get();

        foreach ($technicians as $technician) {
            $wallet = $technician->wallet;
            $lastOutgoingTransaction = $wallet->lastOutgoingTransactions();

            if ($lastOutgoingTransaction == null) {
                // basically at this point we're dealing with a huge bug..
                // it maybe just  a data manipulation problem
                // but to prevent such problems to raiss at your eyes again,
                //let's de-activate the technicain and we're all done :)
                $technician->state = "Inactive";
                $technician->save();
                Mail::to($technician->email)->send(new \App\Mail\SubscriptionEnded($technician));

                continue;
            }
            // Your logic to check and renew subscriptions
            if ($lastOutgoingTransaction->due <= now()) {
                // Renew subscription logic
                $technician->state = "Inactive";
                Mail::to($technician->email)->send(new \App\Mail\SubscriptionEnded($technician));
                $technician->save();
                // send email to technicain telling his/her subscription is done
            }
        }

        $this->info('Subscription check completed successfully.');
    }
}
