<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidCardMovement extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->morphTo();
    }
}
