<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    public function programmer(): BelongsTo
    {
        return $this->belongsTo(Programmer::class, "programmer_id");
    }

    public function images() : HasMany {
        return $this->hasMany(ProjectImage::class);
    }
}
