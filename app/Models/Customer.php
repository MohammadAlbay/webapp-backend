<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customer extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = [
    //     'id',
    //     'fullname',
    //     'email',
    //     'password',
    //     'state',
    //     'profile',
    //     'phone',
    //     'address',
    //     'dender'
    // ];


    public function reservations() : HasMany {
        return $this->hasMany(\App\Models\Reservation::class);
    }

    protected static function booted()
    {
        static::created(function ($customer) {
            $customer->wallet()->create();
        });
    }
    
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }


    public function transactions() {
        return $this->morphMany(PrepaidCardMovement::class, 'owner');
    }

    public function comments()
    {
        return $this->morphMany(PostComment::class, 'owner');
    }
}
