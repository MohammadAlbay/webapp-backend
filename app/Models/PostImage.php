<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();
        
        // Attach event handler, on deleting of the file
        PostImage::deleting(function($postMedia)
        {   
            unlink(public_path(). $postMedia->image);
        });
    }

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
