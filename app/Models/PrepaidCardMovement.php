<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrepaidCardMovement extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['card_serial'];
    public $card_serial;

    public function getCardSerialAttribute()
    {
        // Process the rate value as needed
        $this->processSerial();
        return $this->card_serial;
    }
    
    public function owner()
    {
        return $this->morphTo();
    }

    public function card() {
        return PrepaidCard::find($this->prepaidcard_id);
    }

    public function processSerial() {
        $this->card_serial = $this->card()->serial;
    }
}
