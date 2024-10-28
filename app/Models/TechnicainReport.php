<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicainReport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function technicain()
    {
        return Technicain::find($this->technicain_id);
    }
    public function customer()
    {
        return Customer::find($this->customer_id);
    }
}
