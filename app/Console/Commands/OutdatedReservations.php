<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OutdatedReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outdated-reservations:check';

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
        // reservations (past) not marked as Done
        $reservations = Reservation::where('state', "InProgress")
                        ->orWhere('state', 'Accepted')->get();

        $today = Carbon::today();
        
        foreach ($reservations as $r) {
            $reservationDate = $r->date;
            
            if ($reservationDate->diffInDays($today) >=  1 && $reservationDate->isPast()) {
                // now the "r" is old by one day. so we should check if r is "InProgress"
                // then, we should update it to Done. and if "Accepted" we should update it
                // to Refused

                if($r->state == "InProgress") 
                    $r->state = "Done";
                 else 
                    $r->state = "Refused";

                $r->save();
            }
        }

        $this->info('Outdated reservations check completed successfully.');
    }
}
