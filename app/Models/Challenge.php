<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'challenge_post');
    }
}
