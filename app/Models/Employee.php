<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\EmployeeRole;
class Employee extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($employee) {
            $employee->wallet()->create();
        });
    }
    
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }
    
    public function transactions() {
        return $this->morphMany(PrepaidCardMovement::class, 'owner');
    }
    
    public function roles() : HasMany {
        return $this->hasMany(EmployeeRole::class);
    }
}
