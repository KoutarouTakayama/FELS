<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearnedLesson extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id', 'category_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
