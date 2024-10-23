<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrepaidCardMovement extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function owner()
    {
        return $this->morphTo();
    }

    public function card() {
        return PrepaidCard::find($this->prepaidcard_id);
    }
}
