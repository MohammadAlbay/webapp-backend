<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgrammerSkill extends Model
{
    use HasFactory;

    public function programmer() : BelongsTo {
        return $this->belongsTo(Programmer::class, "programmer_id");
    }

    public function skill() : BelongsTo {
        return $this->belongsTo(Skill::class, "skill_name");
    }
}
