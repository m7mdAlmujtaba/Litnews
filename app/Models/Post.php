<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    const EXCERPT_LENGTH = 100;

    public function user(){
        return $this->belongsTo(User::class, 'author');
    }

    public function excerpt()
    {
        return Str::limit($this->body, Post::EXCERPT_LENGTH);
    }
}
