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
}
