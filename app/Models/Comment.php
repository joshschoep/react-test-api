<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $fillable = array('content', 'owner_id', 'post_id');

    public function post() {
        return $this->belongsTo(BlogPost::class, 'post_id');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
