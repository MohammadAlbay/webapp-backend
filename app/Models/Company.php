<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Company extends Authenticatable
{
    use HasFactory;


    protected $fillable = [
        'fullname',
        'subname',
        'email',
        'password',
        'status',
        'description',
        'profile',
        'address'
    ];
    public function ads() : HasMany {
        return $this->hasMany(Advertisement::class);
    }
}
