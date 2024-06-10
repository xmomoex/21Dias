<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['body', 'user_id', 'group_id', 'deleted_by', 'deleted_at', 'file_path', 'is_public'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function reactions()
    {
        return $this->hasMany(PostReaction::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
