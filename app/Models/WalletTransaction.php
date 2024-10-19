<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inWallet() {
        return Wallet::find($this->wallet_in_id);
    }

    public function outWallet() {
        return Wallet::find($this->wallet_out_id);
    }
}
