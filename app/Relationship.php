<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id', 'following_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
