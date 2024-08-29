<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function owner() {
    //     if($this->customer_id == null && $this->technicain_id == null)
    //         return Employee::findOrFail($this->employee_id);
    //     else if($this->customer_id == null && $this->employee_id == null) 
    //         return Technicain::findOrFail($this->technicain_id);
    //     else
    //         return Customer::findOrFail($this->customer_id);
    // }

    public function owner()
    {
        return $this->morphTo();
    }
}
