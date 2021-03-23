<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;

    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $fillable = array('title', 'lead', 'content', 'owner_id');

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
