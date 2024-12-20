<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Technicain extends Authenticatable  implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    protected $guarded = [];

    protected $appends = ['rate', 'specializationName'];
    public $rate;

    public function getspecializationNameAttribute() {
        return $this->specializationName();
    }

    public function getRateAttribute()
    {
        // Process the rate value as needed
        $this->processRate();
        return $this->rate;
    }
    public function processRate() {
        $this->rate = $this->rateValue();
    }
    protected static function booted()
    {
        static::created(function ($technician) {
            $technician->wallet()->create();
        });
    }
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    public function transactions() {
        return $this->morphMany(PrepaidCardMovement::class, 'owner');
    }

    public function specializationName():String {
        return Specialization::find($this->specialization_id)->name;
    }

    public function comments()
    {
        return $this->morphMany(PostComment::class, 'owner');
    }



    public function subscriptionCheck() {
        $wallet = $this->wallet;
        $lastOutgoingTransaction = $wallet->lastOutgoingTransactions();
            // Your logic to check and renew subscriptions
        if ($lastOutgoingTransaction->due <= now()) {
            return false;
        } 
        
        return true;
    }

    public function pendingReservations() {
        return Reservation::where('technicain_id', $this->id)
                        ->where('state', 'Pending')->get();
    }

    public function acceptedReservations() {
        return Reservation::where('technicain_id', $this->id)
                        ->where('state', 'Accepted')->get();
    }

    public function inProgressReservations() {
        return Reservation::where('technicain_id', $this->id)
                        ->where('state', 'InProgress')->get();
    }

    public function notDoneReservations() {
        return Reservation::where('technicain_id', $this->id)
                        ->where('state', 'InProgress')
                        ->orWhere('state', 'Accepted')->get();
    }
    
    public function rateValue() {
        $rates = Rate::where('technicain_id', $this->id)->get('rate');
        $value = 0;
        $count = $rates->count();

        if($count == 0)
            return 0;

        foreach($rates as $r) {
            $value += $r->rate;
        }

        return $value / $count;
    }

    public function reportsUponMe($only_active = false) {
        return $only_active ? 
            CustomerReport::where('technicain_id', $this->id)
            ->where('state', '!=', 'Done')->get()
            : CustomerReport::where('technicain_id', $this->id)->get();
    }
}
