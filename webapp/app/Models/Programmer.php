<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Programmer extends Authenticatable
{
    
    use HasFactory;


    protected $fillable = [
        'fullname',
        'subname',
        'email',
        'password',
        'studied_at',
        'profile',
        'address'
    ];
    
    public function projects() : HasMany {
        return $this->hasMany(Project::class);
    }

    public function skills() : HasMany {
        return $this->hasMany(ProgrammerSkill::class);
    }
}
