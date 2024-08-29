<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Technicain extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];


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
}
