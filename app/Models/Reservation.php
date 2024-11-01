<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function technicain() {
        return Technicain::find($this->technicain_id);
    }

    public function specializedFor() {
        return $this->technicain()->specializationName();
    }
    public function customer() {
        return Customer::find($this->customer_id);
    }

    public function sweetStateName() {
        switch($this->state) {
            case "Pending":
                    return "قيد الانتظار";
            case "Accepted":
                    return "تم القبول";
            case "Refused":
                    return "تم الرفض";
            case "InProgress":
                    return "قيد العمل";
            case "Done":
                    return "مكتمل";
            default:
                    return "لا يوجد";
        }
    }
}
